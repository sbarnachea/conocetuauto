<?php 
class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'add', 'get_provincias', 'get_comunas'); 
	}

	public function login() {
		$this->layout = 'login';
		//revisa si ya estas logeado
		if($this->Session->check('Auth.User')){
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));      
		}
		//revisa que venga post
		if ($this->request->is('post')) {
			//logea con el componente Auth
			if ($this->Auth->login()) {
				if($this->Session->read('Auth.User.cambiar_pass')){
					$this->redirect(array('action' => 'cambiar_pass', $this->Session->read('Auth.User.id')));
				}
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Usuario o Contraseña Incorrecta'), 'default', array('class' => 'alert alert-danger'));
			}
		} 
	}

	public function logout() {
		//deslogea con el componente Auth
		$this->redirect($this->Auth->logout());
	}

	public function cambiar_pass($idUsuario){
		$this->layout = 'login';
		$this->loadModel('User');

		if(!empty($this->data['User'])){
			//pregunta que las contraseñas coincidan
			if($this->data['User']['password'] != $this->data['User']['password2']){
				$this->Session->setFlash('Contraseñas no coinciden', 'default', array('class' => 'alert alert-danger'));
			}else{
				$usuario = array();

				$usuario['User']['id'] = $idUsuario;
				$usuario['User']['password'] = AuthComponent::password($this->data['User']['password']);
				$usuario['User']['cambiar_pass'] = 0;
				//guarda el usuario
				if($this->User->save($usuario)){
					$this->Session->setFlash(__('Contraseña cambiada con éxito'), 'default', array('class' => 'alert alert-info alert-index'));
					$this->redirect(array('controller' => 'marca', 'action' => 'index'));
				}else{
					$this->Session->setFlash(__('Ocurrio un error, intentelo de nuevo'), 'default', array('class' => 'alert alert-danger'));
				}
			}
		}
		$this->set('idUsuario', $idUsuario);
	}

	public function add(){
		$this->layout = 'login';

		//cargo modelo
		$this->loadModel('Persona');
		$this->loadModel('Region');
		$bandera = true;
		$usuario = $correo = $cliente = $sessionUsuario = $persona = array();
		//si viene preuser, lo mando a la vista
		if(!empty($this->data['PreUser'])){
			$usuario = array();
			$usuario['username'] = $this->data['PreUser']['username'];
			$usuario['password'] = $this->data['PreUser']['password'];
			$usuario['email'] = $this->data['PreUser']['email'];

			$this->set('usuario', $usuario);
		}
		//valido si ya esta logeado
		if($this->Session->check('Auth.User')){
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));      
		}else{
			//si viene this data, lo valido para poder guardarlo
			if(!empty($this->data['User'])){
				$userEqual = $this->Persona->User->find('first', array(
					'conditions' => array('username' => $this->data['User']['username'])
				));
				//valido que no haya otro username igual
				if(!empty($userEqual)){
					$bandera = false;
					$this->Session->setFlash('Nombre de usuario no disponible', 'default', array('class' => 'alert alert-danger'));
				}
				//valido que las contraseñas coincidan
				if($this->data['User']['password'] != $this->data['User']['password2']){
					$bandera = false;
					$this->Session->setFlash('Contraseñas no coinciden', 'default', array('class' => 'alert alert-danger'));
				}
				// si todo se cumple empezamos a guardar
				if($bandera){
					// se crea usuario
					$usuario['User']['username'] = $this->data['User']['username'];
					$usuario['User']['password'] = AuthComponent::password($this->data['User']['password']);
					$usuario['User']['id_tipo_usuario'] = $this->data['User']['tipousuario'];
					$usuario['User']['cambiar_pass'] = 0;
					$this->Persona->User->save($usuario);
					
					// se crea correo
					$correo['Correo']['direccion'] = $this->data['User']['email'];
					$proveedor = explode('@', $this->data['User']['email']);
					$correo['Correo']['proveedor'] = $proveedor[1];
					$this->Persona->Correo->save($correo);

					//si es tipo usuario normal creamos una persona 
					if($this->data['User']['tipousuario'] == 1){
						$persona['Persona']['nombre'] = $this->data['User']['nombre'];
						$persona['Persona']['paterno'] = $this->data['User']['paterno'];
						$persona['Persona']['id_usuario'] = $this->Persona->User->id;
						$persona['Persona']['id_correo'] = $this->Persona->Correo->id;
						$this->Persona->save($persona);
					// si es tipo usuario empresa creamos un cliente
					}elseif($this->data['User']['tipousuario'] == 2){
						$this->loadModel('Cliente');
						$cliente['Cliente']['nombre'] = $this->data['User']['nombre'];
						$cliente['Cliente']['telefono'] = $this->data['User']['telefono'];
						$cliente['Cliente']['direccion'] = $this->data['User']['direccion'];
						$cliente['Cliente']['id_region'] = $this->data['User']['id_region'];
						$cliente['Cliente']['id_provincia'] = $this->data['User']['id_provincia'];
						$cliente['Cliente']['id_comuna'] = $this->data['User']['id_comuna'];
						$cliente['Cliente']['id_usuario'] = $this->Persona->User->id;
						$cliente['Cliente']['id_correo'] = $this->Persona->Correo->id;
						$this->Cliente->save($cliente);
					}
					// se busca el usuario para poder crear su session y poder logearlo
					$user = $this->Persona->User->find('first', array(
						'conditions' => array('User.id' => $this->Persona->User->id)
					));
					$sessionUsuario['User'] = $user['User'];
					$sessionUsuario['User']['TipoUsuario'] = $user['TipoUsuario'];
					$this->Session->write('Auth', $sessionUsuario);
					$this->redirect(array('controller' => 'marca', 'action' => 'index'));
				}
			}
		}
		$regiones = $this->Region->find('list', array(
			'fields' => array('id', 'nombre')
		));

		$this->set(compact('regiones'));
	}
	public function get_provincias($idRegion){
		$this->AutoRender = false;
		$this->layout = 'ajax';
		//se carga modelo
		$this->loadModel('Provincia');
		//se hace la consulta a a base de datos
		$provinciasD = $this->Provincia->find('all', array(
			'fields' => array('id', 'nombre'),
			'conditions' => array('Provincia.id_region' => $idRegion)
		));
		//se recorren y ordenan las provincias
		$provincias = array();
		foreach($provinciasD as $provincia){
			$provincias[$provincia['Provincia']['id']] = $provincia['Provincia']['nombre'];
		}
		//se envia a la vista
		$this->set(compact('provincias'));
	}
	public function get_comunas($idProvincia){
		$this->AutoRender = false;
		$this->layout = 'ajax';
		//se carga modelo
		$this->loadModel('Comuna');
		//se hace la consulta a la base de datos
		$comunasD = $this->Comuna->find('all', array(
			'fields' => array('id', 'nombre'),
			'conditions' => array('Comuna.id_provincia' => $idProvincia)
		));
		//se recorren y ordenan las comunas
		$comunas = array();
		foreach($comunasD as $comuna){
			$comunas[$comuna['Comuna']['id']] = $comuna['Comuna']['nombre'];
		}
		//se envian a la vista
		$this->set(compact('comunas'));
	}
}
?>
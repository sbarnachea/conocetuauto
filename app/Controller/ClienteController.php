<?php 
class ClienteController extends AppController {
		
	public function listado(){
		$this->loadModel('Valoracion');

		$clientes = $this->Valoracion->Cliente->find('all');
		$ranking = $this->Valoracion->ranking();
		$arreglo = array();

		foreach ($ranking as $keyR => $taller) {
			$ranking[$keyR]['Cliente'] = $taller;
			$correo = $this->Valoracion->Cliente->Correo->find('first', array('conditions' => array('Correo.id' => $taller['Cliente']['id_correo'])));
			$ranking[$keyR]['Cliente'] += $correo;
			$comuna = $this->Valoracion->Cliente->Comuna->find('first', array('conditions' => array('Comuna.id' => $taller['Cliente']['id_comuna'])));
			$ranking[$keyR]['Cliente'] += $comuna;
			foreach ($clientes as $key => $cliente) {
				if($cliente['Cliente']['id'] == $taller['Cliente']['id']){
					$arreglo[] = $cliente['Cliente']['id'];
				}
			}
		}
		foreach ($clientes as $key => $cliente) {
			if(!in_array($cliente['Cliente']['id'], $arreglo)){
				$ranking[]['Cliente'] = $cliente;
			}
		}

		$this->set(compact('ranking'));
	}
	public function detalle($idCliente){
		$this->loadModel('Valoracion');

		$cliente = $this->Valoracion->Cliente->find('first', array(
			'conditions' => array('Cliente.id' => $idCliente),
			'contain' => array(
				'Valoracion' => array(
					'fields' => array('avg(estrellas) as promedio')
				),
				'Region',
				'Comuna',
				'Correo'
			)
		));

		$valoracion = $this->Valoracion->find('first', array(
			'conditions' => array('Valoracion.id_usuario' => $this->Session->read('Auth.User.id'), 'Valoracion.id_cliente' => $idCliente)
		));

		$this->set(compact('cliente', 'valoracion'));
	}
	public function votar($idCliente, $idUsuario, $estrellas){
		$this->AutoRender = false;
		$this->layout = 'ajax';

		$this->loadModel('User');

		$cliente = $this->User->Cliente->find('first', array(
			'fields' => array('Cliente.id'),
			'conditions' => array('Cliente.id' => $idCliente)
		));	
		if(empty($cliente)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'talleres'));
		}
		$usuario = $this->User->find('first', array(
			'fields' => array('User.id'),
			'conditions' => array('User.id' => $idUsuario)
		));	
		if(empty($usuario) || $idUsuario != $this->Session->read('Auth.User.id')){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'talleres'));
		}
		$valoracionOld = $this->User->Cliente->Valoracion->find('first', array(
			'fields' => array('Valoracion.id'),
			'conditions' => array('Valoracion.id_usuario' => $idUsuario, 'Valoracion.id_cliente' => $idCliente)
		));
		$valoracion = array();
		if(!empty($valoracionOld)){
			$valoracion['id'] = $valoracionOld['Valoracion']['id'];
		}
		$valoracion['id_usuario'] = $idUsuario;
		$valoracion['id_cliente'] = $idCliente;
		$valoracion['estrellas'] = $estrellas;

		if($this->User->Cliente->Valoracion->save($valoracion)){
			$this->set('estado', array('status' =>'success'));
		}else{
			$this->set('estado', array('status' =>'error'));
		}
	}
	public function perfil(){
		$this->loadModel('Cliente');

		if(!empty($this->data['Cliente'])){
			$correo = array();
			$correo['Correo']['id'] = $this->data['Correo']['id'];
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];

			if($this->Cliente->Correo->save($correo)){
				if($this->Cliente->save($this->data['Cliente'])){
					$this->Session->setFlash(__('Perfil editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Perfil no editado, intente nuevamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
				$this->redirect(array('controller' => 'perfil'));
			}
		}
		if(!empty($this->data['User'])){
			if($this->data['User']['password'] != $this->data['User']['password2']){
				$this->Session->setFlash('Contraseñas no coinciden', 'default', array('class' => 'alert alert-danger alert-index'));
			}else{
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
				if($this->Persona->User->save($this->data['User'])){
					$this->Session->setFlash(__('Contraseña editada correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Contraseña no editada, intente nuevamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
				$this->redirect(array('controller' => 'perfil'));
			}
		}
		$regiones = $this->Cliente->Region->find('list', array(
			'fields' => array('id', 'nombre')
		));

		$cliente = $this->Cliente->find('first', array(
			'conditions' => array('Cliente.id' => $this->Session->read('Auth.User.Cliente.id'))
		));

		$this->set(compact('cliente', 'regiones'));
	}
}
?>
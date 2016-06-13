<?php 
class AdminController extends AppController {
	
	public $components = array('Paginator');

	public function index(){
		$this->loadModel('Marca');

		if(!empty($this->data['nombre'])){
			$conditions['nombre LIKE'] = '%' . $this->data['nombre'] . '%';
			$marcasBusqueda = $this->Marca->find('all', array(
				'conditions' => array('nombre LIKE' => '%' . $this->data['nombre'] . '%'),
				'order' => 'Marca.nombre ASC'
			));
			$nombre = $this->data['nombre'];
			$this->set(compact('marcasBusqueda', 'nombre'));
		}else{
			$this->Paginator->settings = array(
				'limit' => 15,
				'order' => 'Marca.nombre ASC'
			);
			$marcasPaginator = $this->Paginator->paginate('Marca');
			$this->set(compact('marcasPaginator'));
		}
	}
	public function add_marca(){
		$this->loadModel('Marca');

		if(!empty($this->data)){
			$marca = array();
			$marca['nombre'] = $this->data['Marca']['nombre'];
			$marca['portada'] = $this->data['Marca']['portada'];
			$marca['imagen'] = $this->data['Marca']['imagen']['name'];

			define ('SITE_ROOT', realpath(dirname(__FILE__)));
			$nombrearchivo = SITE_ROOT . '/vendors/img/marca/' . $this->data['Marca']['imagen']['name'];
			$nombrearchivo = explode('/app/Controller', $nombrearchivo);
			$nombre = $nombrearchivo[0] . $nombrearchivo[1];

			if($this->Marca->save($marca)){		
				if (move_uploaded_file($this->data['Marca']['imagen']['tmp_name'],$nombre)){
					$this->Session->setFlash(__('Marca creada correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
			}else{
				$this->Session->setFlash(__('Marca no creada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'index'));
		}
	}
	public function edit_marca($idMarca){
		$this->loadModel('Marca');

		if(!empty($this->data)){
			$marca = array();
			$marca['id'] = $this->data['Marca']['id'];
			$marca['nombre'] = $this->data['Marca']['nombre'];
			$marca['portada'] = $this->data['Marca']['portada'];
			if(!empty($this->data['Marca']['imagen']['name'])){
				$marca['imagen'] = $this->data['Marca']['imagen']['name'];

				define ('SITE_ROOT', realpath(dirname(__FILE__)));
				$nombrearchivo = SITE_ROOT . '/vendors/img/marca/' . $this->data['Marca']['imagen']['name'];
				$nombrearchivo = explode('/app/Controller', $nombrearchivo);
				$nombre = $nombrearchivo[0] . $nombrearchivo[1];
				move_uploaded_file($this->data['Marca']['imagen']['tmp_name'],$nombre);
			}

			if($this->Marca->save($marca)){		
				$this->Session->setFlash(__('Marca editada correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Marca no editada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_marca', $idMarca));
		}
		$marca = $this->Marca->find('first', array(
			'fields' => array('imagen', 'nombre', 'portada'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		$this->set(compact('marca'));
	}
	public function delete_marca($idMarca){
		$this->AutoRender = false;
		$this->loadModel('Marca');

		$conditions = array(
			'Marca.id' => $idMarca,
			'Marca.deleted' => 0
		);
		if ($this->Marca->hasAny($conditions)){
			if($this->Marca->delete($idMarca)){		
				$this->Session->setFlash(__('Marca eliminada'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Marca no eliminada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'index'));
		}
	}
	public function list_modelo($idMarca){
		$this->loadModel('Modelo');

		$marca = $this->Modelo->Marca->find('first', array(
			'fields' => array('id', 'nombre', 'imagen'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		$this->Paginator->settings = array(
			'limit' => 15,
			'conditions' => array('Modelo.id_marca' => $idMarca),
			'contain' => array('TipoVehiculo'),
			'order' => 'Modelo.id ASC'
		);
		$modelos = $this->Paginator->paginate('Modelo');
		$this->set(compact('marca', 'modelos'));
	}
	public function add_modelo($idMarca){
		$this->loadModel('Marca');

		if(!empty($this->data)){

			if($this->Marca->Modelo->save($this->data)){		
				$this->Session->setFlash(__('Modelo creado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Modelo no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'list_modelo', $idMarca));
		}
		$tiposVehiculos = $this->Marca->Modelo->TipoVehiculo->find('list', array('fields' => array('id', 'nombre')));
		$marca = $this->Marca->find('first', array(
			'fields' => array('nombre', 'id', 'imagen'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		$this->set(compact('marca', 'tiposVehiculos'));
	}
	public function edit_modelo($idMarca, $idModelo){
		$this->loadModel('Modelo');

		if(!empty($this->data)){

			if($this->Modelo->save($this->data)){		
				$this->Session->setFlash(__('Modelo editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Modelo no editado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_modelo', $idMarca, $idModelo));
		}
		$tiposVehiculos = $this->Modelo->TipoVehiculo->find('list', array('fields' => array('id', 'nombre')));
		$modelo = $this->Modelo->find('first', array(
			'fields' => array('nombre', 'id', 'id_tipo_vehiculo'),
			'conditions' => array('Modelo.id' => $idModelo),
			'contain' => array(
				'Marca' => array(
					'fields' => array('nombre', 'id', 'imagen'),
					'conditions' => array('Marca.id' => $idMarca)
				)
			)
		));
		$this->set(compact('modelo', 'tiposVehiculos'));
	}
	public function delete_modelo($idMarca, $idModelo){
		$this->AutoRender = false;
		$this->loadModel('Modelo');

		$conditions = array(
			'Modelo.id' => $idModelo,
			'Modelo.deleted' => 0
		);
		if ($this->Modelo->hasAny($conditions)){
			if($this->Modelo->delete($idModelo)){		
				$this->Session->setFlash(__('Modelo eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Modelo no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'list_modelo', $idMarca));
		}
	}
	public function tipo_vehiculos(){
		$this->loadModel('TipoVehiculo');

		$this->Paginator->settings = array(
			'limit' => 15
		);
		$tiposVehiculos = $this->Paginator->paginate('TipoVehiculo');

		$this->set(compact('tiposVehiculos'));
	}
	public function add_tipo_vehiculo(){
		$this->loadModel('TipoVehiculo');

		if(!empty($this->data)){

			if($this->TipoVehiculo->save($this->data)){		
				$this->Session->setFlash(__('Tipo Vehiculo creado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Vehiculo no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'tipo_vehiculos'));
		}
	}
	public function edit_tipo_vehiculo($idTipoVehiculo){
		$this->loadModel('TipoVehiculo');

		if(!empty($this->data)){
			if($this->TipoVehiculo->save($this->data)){		
				$this->Session->setFlash(__('Tipo Vehiculo editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Vehiculo no editado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_tipo_vehiculo', $idTipoVehiculo));
		}
		$tipoVehiculo = $this->TipoVehiculo->find('first', array(
			'fields' => array('nombre', 'id'),
			'conditions' => array('TipoVehiculo.id' => $idTipoVehiculo),
		));
		$this->set(compact('tipoVehiculo'));
	}
	public function delete_tipo_vehiculo($idTipoVehiculo){
		$this->AutoRender = false;
		$this->loadModel('TipoVehiculo');

		$conditions = array(
			'TipoVehiculo.id' => $idTipoVehiculo,
			'TipoVehiculo.deleted' => 0
		);
		if ($this->TipoVehiculo->hasAny($conditions)){
			if($this->TipoVehiculo->delete($idTipoVehiculo)){		
				$this->Session->setFlash(__('Tipo Vehiculo eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Vehiculo no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'tipo_vehiculos'));
		}
	}
	public function tipo_fallas(){
		$this->loadModel('TipoFalla');

		$this->Paginator->settings = array(
			'limit' => 15
		);
		$tiposfallas = $this->Paginator->paginate('TipoFalla');

		$this->set(compact('tiposfallas'));
	}
	public function add_tipo_falla(){
		$this->loadModel('TipoFalla');

		if(!empty($this->data)){

			if($this->TipoFalla->save($this->data)){		
				$this->Session->setFlash(__('Tipo Falla creado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Falla no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'tipo_fallas'));
		}
	}
	public function edit_tipo_falla($idTipoFalla){
		$this->loadModel('TipoFalla');

		if(!empty($this->data)){
			if($this->TipoFalla->save($this->data)){		
				$this->Session->setFlash(__('Tipo Falla editada correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Falla no editada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_tipo_falla', $idTipoFalla));
		}
		$tipoFalla = $this->TipoFalla->find('first', array(
			'fields' => array('nombre', 'id'),
			'conditions' => array('TipoFalla.id' => $idTipoFalla),
		));
		$this->set(compact('tipoFalla'));
	}
	public function delete_tipo_falla($idTipoFalla){
		$this->AutoRender = false;
		$this->loadModel('TipoFalla');

		$conditions = array(
			'TipoFalla.id' => $idTipoFalla,
			'TipoFalla.deleted' => 0
		);
		if ($this->TipoFalla->hasAny($conditions)){
			if($this->TipoFalla->delete($idTipoFalla)){		
				$this->Session->setFlash(__('Tipo Falla eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Tipo Falla no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'tipo_fallas'));
		}
	}
	public function talleres(){
		$this->loadModel('Cliente');

		if(!empty($this->data['nombre'])){
			$conditions['nombre LIKE'] = '%' . $this->data['nombre'] . '%';
			$talleresBusqueda = $this->Cliente->find('all', array(
				'conditions' => array('Cliente.nombre LIKE' => '%' . $this->data['nombre'] . '%'),
				'order' => 'Cliente.nombre ASC'
			));
			$nombre = $this->data['nombre'];
			$this->set(compact('talleresBusqueda', 'nombre'));
		}else{
			$this->Paginator->settings = array(
				'limit' => 15,
				'contain' => array(
					'Correo'
				),
				'order' => 'Cliente.nombre ASC'
			);
			$talleresPaginator = $this->Paginator->paginate('Cliente');
			$this->set(compact('talleresPaginator'));
		}
	}
	public function add_taller(){
		$this->loadModel('Cliente');

		if(!empty($this->data)){
			$user = $correo = array();
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];

			$user['User']['username'] = $this->data['User']['username'];
			$user['User']['password'] = AuthComponent::password($this->data['User']['password']);
			$user['User']['id_tipo_usuario'] = 2;
			$user['User']['cambiar_pass'] = 1;

			if($this->Cliente->User->save($user)){
				$this->request->data['Cliente']['id_usuario'] = $this->Cliente->User->id;
				if($this->Cliente->Correo->save($correo)){
					$this->request->data['Cliente']['id_correo'] = $this->Cliente->Correo->id;
					if($this->Cliente->save($this->data['Cliente'])){	
						$this->Session->setFlash(__('Taller creado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
					}else{
						$this->Session->setFlash(__('Taller no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
					}
				}
			}else{
				$this->Session->setFlash(__('Taller no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'talleres'));
		}
		$regiones = $this->Cliente->Region->find('list', array(
			'fields' => array('id', 'nombre')
		));

		$this->set(compact('regiones'));
	}
	public function edit_taller($idCliente){
		$this->loadModel('Cliente');

		$taller = $this->Cliente->find('first', array(
			'conditions' => array('Cliente.id' => $idCliente),
		));
		if(!empty($this->data)){
			$correo = array();
			if($taller['Cliente']['id_correo'] > 0){
				$correo['Correo']['id'] = $taller['Cliente']['id_correo'];
			}
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];
			if($this->Cliente->Correo->save($correo)){
				$this->request->data['Cliente']['id_correo'] = $this->Cliente->Correo->id;
				if($this->Cliente->save($this->data['Cliente'])){	
					$this->Session->setFlash(__('Taller editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Taller no editado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
				}
			}
			
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_taller', $idCliente));
		}
		$regiones = $this->Cliente->Region->find('list', array(
			'fields' => array('id', 'nombre')
		));
		$this->set(compact('taller', 'regiones'));
	}
	public function delete_taller($idCliente){
		$this->AutoRender = false;
		$this->loadModel('Cliente');

		$conditions = array(
			'Cliente.id' => $idCliente,
			'Cliente.deleted' => 0
		);
		$cliente = $this->Cliente->find('first', array('conditions' => array('Cliente.id' => $idCliente)));
		$idUsuario = $cliente['Cliente']['id_usuario'];
		if ($this->Cliente->hasAny($conditions)){
			if($this->Cliente->delete($idCliente)){		
				$this->Cliente->User->delete($idUsuario);
				$this->Session->setFlash(__('Taller eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Taller no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'talleres'));
		}
	}
	public function usuarios(){
		$this->loadModel('Persona');

		if(!empty($this->data['nombre'])){
			$conditions['nombre LIKE'] = '%' . $this->data['nombre'] . '%';
			$usuariosBusqueda = $this->Persona->find('all', array(
				'conditions' => array('Persona.nombre LIKE' => '%' . $this->data['nombre'] . '%'),
				'contain' => array(
					'Correo',
					'User' => array(
						'TipoUsuario'
					)
				),
				'order' => 'Persona.nombre ASC'
			));
			$nombre = $this->data['nombre'];
			$this->set(compact('usuariosBusqueda', 'nombre'));
		}else{
			$this->Paginator->settings = array(
				'limit' => 15,
				'contain' => array(
					'Correo',
					'User' => array(
						'TipoUsuario'
					)
				),
				'order' => 'Persona.id DESC'
			);
			$usuariosPaginator = $this->Paginator->paginate('Persona');
			$this->set(compact('usuariosPaginator'));
		}
	}
	public function add_usuario(){
		$this->loadModel('Persona');

		if(!empty($this->data)){
			$user = $correo = array();
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];

			$user['User']['username'] = $this->data['User']['username'];
			$user['User']['password'] = AuthComponent::password($this->data['User']['password']);
			$user['User']['id_tipo_usuario'] = $this->data['User']['id_tipo_usuario'];
			$user['User']['cambiar_pass'] = 1;

			if($this->Persona->User->save($user)){
				$this->request->data['Persona']['id_usuario'] = $this->Persona->User->id;
				if($this->Persona->Correo->save($correo)){
					$this->request->data['Persona']['id_correo'] = $this->Persona->Correo->id;
					if($this->Persona->save($this->data['Persona'])){	
						$this->Session->setFlash(__('Usuario creado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
					}else{
						$this->Session->setFlash(__('Usuario no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
					}
				}
			}else{
				$this->Session->setFlash(__('Usuario no creado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'usuarios'));
		}
	}
	public function edit_usuario($idPersona){
		$this->loadModel('Persona');

		$usuario = $this->Persona->find('first', array(
			'conditions' => array('Persona.id' => $idPersona)
		));
		if(!empty($this->data)){
			$user = $correo = array();
			if($usuario['Persona']['id_correo'] > 0){
				$correo['Correo']['id'] = $usuario['Persona']['id_correo'];
			}
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];

			$persona = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idPersona)));
			$idUsuario = $persona['Persona']['id_usuario'];
			$user['User']['id'] = $idUsuario;
			$user['User']['id_tipo_usuario'] = $this->data['User']['id_tipo_usuario'];
			if($this->Persona->Correo->save($correo)){
				$this->request->data['Persona']['id_correo'] = $this->Persona->Correo->id;
				if($this->Persona->save($this->data['Persona'])){
					$this->Persona->User->save($user);	
					$this->Session->setFlash(__('Usuario editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Usuario no editado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
				}
			}
			
			$this->redirect(array('controller' => 'admin', 'action' => 'edit_usuario', $idPersona));
		}
		$this->set(compact('usuario'));
	}
	public function delete_usuario($idPersona){
		$this->AutoRender = false;
		$this->loadModel('Persona');

		$conditions = array(
			'Persona.id' => $idPersona,
			'Persona.deleted' => 0
		);
		$persona = $this->Persona->find('first', array('conditions' => array('Persona.id' => $idPersona)));
		$idUsuario = $persona['Persona']['id_usuario'];
		if ($this->Persona->hasAny($conditions)){
			if($this->Persona->delete($idPersona)){		
				$this->Persona->User->delete($idUsuario);
				$this->Session->setFlash(__('Usuario eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Usuario no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'usuarios'));
		}
	}
	public function anuncios(){
		$this->loadModel('Anuncio');
		$total = $this->Anuncio->find('all', array(
			'fields' => array('count(*) as total')
		));
		$espera = $this->Anuncio->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('Anuncio.estado' => 0)
		));
		$aprobado = $this->Anuncio->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('Anuncio.estado' => 1)
		));
		$finalizado = $this->Anuncio->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('Anuncio.estado' => 2)
		));
		if(!empty($this->data['nombre'])){
			$conditions['titulo LIKE'] = '%' . $this->data['nombre'] . '%';
			$anunciosBusqueda = $this->Anuncio->find('all', array(
				'conditions' => array('Anuncio.titulo LIKE' => '%' . $this->data['nombre'] . '%'),
				'order' => 'Anuncio.estado ASC'
			));
			$nombre = $this->data['nombre'];
			$this->set(compact('anunciosBusqueda', 'nombre'));
		}else{
			$this->Paginator->settings = array(
				'limit' => 15,
				'order' => 'Anuncio.estado ASC'
			);
			$anunciosPaginator = $this->Paginator->paginate('Anuncio');
			$this->set(compact('anunciosPaginator'));
		}
		$this->set(compact('total', 'espera', 'aprobado', 'finalizado'));
	}
	public function aprobar_anuncio($idAnuncio){
		$this->loadModel('Anuncio');
		$anuncio = $this->Anuncio->find('first', array(
			'conditions' => array('Anuncio.id' => $idAnuncio)
		));
		if(empty($anuncio)){
			$this->Session->setFlash(__('No existe Anuncio'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'admin', 'action' => 'anuncios'));
		}
		$aprobar = array();
		$aprobar['id'] = $idAnuncio;
		$aprobar['estado'] = 1;
		$aprobar['fecha_inicio'] = date('Y-m-d');
		if($this->Anuncio->save($aprobar)){		
			$this->Session->setFlash(__('Anuncio Aprobado'), 'default', array('class' => 'alert alert-info alert-index'));
		}else{
			$this->Session->setFlash(__('Ocurrio un problema, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
		}
		$this->redirect(array('controller' => 'admin', 'action' => 'anuncios'));	
	}
	public function finalizar_anuncio($idAnuncio){
		$this->loadModel('Anuncio');
		$anuncio = $this->Anuncio->find('first', array(
			'conditions' => array('Anuncio.id' => $idAnuncio)
		));
		if(empty($anuncio)){
			$this->Session->setFlash(__('No existe Anuncio'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'admin', 'action' => 'anuncios'));
		}
		$aprobar = array();
		$aprobar['id'] = $idAnuncio;
		$aprobar['estado'] = 2;
		if($this->Anuncio->save($aprobar)){		
			$this->Session->setFlash(__('Anuncio Finalizado'), 'default', array('class' => 'alert alert-info alert-index'));
		}else{
			$this->Session->setFlash(__('Ocurrio un problema, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
		}
		$this->redirect(array('controller' => 'admin', 'action' => 'anuncios'));	
	}
	public function delete_anuncio($idAnuncio){
		$this->AutoRender = false;
		$this->loadModel('Anuncio');

		$conditions = array(
			'Anuncio.id' => $idAnuncio,
			'Anuncio.deleted' => 0
		);

		if ($this->Anuncio->hasAny($conditions)){
			if($this->Anuncio->delete($idAnuncio)){		
				$this->Session->setFlash(__('Anuncio eliminado'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Anuncio no eliminado, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'anuncios'));
		}	
	}
	public function fallas(){
		$this->loadModel('Falla');

		$fallasTotal = $this->Falla->find('all', array(
			'fields' => array('count(*) as total')
		));
		$fallasPositiva = $this->Falla->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('tipo_comentario' => 0)
		));
		$fallasNegativa = $this->Falla->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('tipo_comentario' => 1)
		));
		$fallasEncuesta = $this->Falla->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('fuente' => 1)
		));

		$this->set(compact('fallasTotal', 'fallasNegativa', 'fallasPositiva', 'fallasEncuesta'));

		if(!empty($this->data['id'])){
			$conditions['id'] = '%' . $this->data['id'] . '%';
			$fallasBusqueda = $this->Falla->find('all', array(
				'conditions' => array('Falla.id' => $this->data['id']),
				'contain' => array(
					'TipoFalla',
					'Vehiculo' => array(
						'Marca',
						'Modelo'
					)
				)
			));
			$id = $this->data['id'];
			$this->set(compact('fallasBusqueda', 'id'));
		}else{
			$this->Paginator->settings = array(
				'limit' => 15,
				'contain' => array(
					'TipoFalla',
					'Vehiculo' => array(
						'Marca',
						'Modelo'
					)
				),
				'order' => 'Falla.created DESC'
			);
			$fallasPaginator = $this->Paginator->paginate('Falla');
			$this->set(compact('fallasPaginator'));
		}
		
	}
	public function delete_falla($idFalla){
		$this->AutoRender = false;
		$this->loadModel('Falla');

		$conditions = array(
			'Falla.id' => $idFalla,
			'Falla.deleted' => 0
		);
		$falla = $this->Falla->find('first', array('conditions' => array('Falla.id' => $idFalla)));
		$idVehiculo = $falla['Falla']['id_vehiculo'];
		
		if ($this->Falla->hasAny($conditions)){
			if($this->Falla->delete($idFalla)){		
				$this->Falla->Vehiculo->delete($idVehiculo);
				$this->Session->setFlash(__('Falla eliminada'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Falla no eliminada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'admin', 'action' => 'fallas'));
		}
	}
}
?>
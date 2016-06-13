<?php 
class FallaController extends AppController {
	
	public $components = array('Paginator');

	public function add($idMarca, $idModelo){
		App::import('Vendor', 'recaptchalib');
		$this->loadModel('Falla');

		if(!empty($this->data)){
			$secret = "6LdRuw0TAAAAAFBchHUNdj54K_mzvnM7q87oo8DO";
			$response = null;
			$reCaptcha = new ReCaptcha($secret);
			if ($this->data["g-recaptcha-response"]) {
				$response = $reCaptcha->verifyResponse(
			        $_SERVER["REMOTE_ADDR"],
			        $this->data["g-recaptcha-response"]
			    );
			}
			if($response == null){
				$this->Session->setFlash(__('Debes completar campo "No soy un robot"'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect(array('controller' => 'falla', 'action' => 'add', $idMarca, $idModelo));
			}
			if($this->Falla->Vehiculo->save($this->data['Vehiculo'])){
				$this->request->data['Falla']['id_vehiculo'] = $this->Falla->Vehiculo->id;
				if($this->Falla->save($this->data['Falla'])){		
					$this->Session->setFlash(__('Falla creada correctamente, gracias por compartir tu experiencia'), 'default', array('class' => 'alert alert-info alert-index'));
					$this->redirect(array('controller' => 'modelo', 'action' => 'detalle', $idMarca, $idModelo));
				}else{
					$this->Session->setFlash(__('Falla no creada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
				}
			}else{
				$this->Session->setFlash(__('Falla no creada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
		}

		$marca = $this->Falla->Vehiculo->Marca->find('first', array(
			'fields' => array('Marca.id', 'Marca.nombre'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$modelo = $this->Falla->Vehiculo->Modelo->find('first', array(
			'fields' => array('Modelo.id', 'Modelo.nombre'),
			'conditions' => array('Modelo.id' => $idModelo)
		));
		if(empty($modelo)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'modelo', 'action' => 'index', $idMarca));
		}

		$tiposFallas = $this->Falla->TipoFalla->find('list', array(
			'fields' => array('TipoFalla.id', 'TipoFalla.nombre'),
		));
		$this->set(compact('modelo', 'marca', 'tiposFallas'));
		
	}
	public function elegir_modelo($idMarca){
		$this->loadModel('Falla');

		if(!empty($this->data)){
			$secret = "6LdRuw0TAAAAAFBchHUNdj54K_mzvnM7q87oo8DO";
			$response = null;
			$reCaptcha = new ReCaptcha($secret);
			if ($this->data["g-recaptcha-response"]) {
				$response = $reCaptcha->verifyResponse(
			        $_SERVER["REMOTE_ADDR"],
			        $this->data["g-recaptcha-response"]
			    );
			}
			if($response == null){
				$this->Session->setFlash(__('Debes completar campo "No soy un robot"'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect(array('controller' => 'falla', 'action' => 'add', $idMarca, $idModelo));
			}
			if($this->Falla->Vehiculo->save($this->data['Vehiculo'])){

				$this->request->data['Falla']['id_vehiculo'] = $this->Falla->Vehiculo->id;
				if($this->Falla->save($this->data['Falla'])){		
					$this->Session->setFlash(__('Falla creada correctamente, gracias por compartir tu experiencia'), 'default', array('class' => 'alert alert-info alert-index'));
					$this->redirect(array('controller' => 'modelo', 'action' => 'index', $idMarca));
				}else{
					$this->Session->setFlash(__('Falla no creada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
				}
			}else{
				$this->Session->setFlash(__('Falla no creada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
		}
		$marca = $this->Falla->Vehiculo->Marca->find('first', array(
			'fields' => array('Marca.id', 'Marca.nombre'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$modelos = $this->Falla->Vehiculo->Modelo->find('list', array(
			'fields' => array('Modelo.id', 'Modelo.nombre'),
			'conditions' => array('Modelo.id_marca' => $idMarca)
		));

		$tiposFallas = $this->Falla->TipoFalla->find('list', array(
			'fields' => array('TipoFalla.id', 'TipoFalla.nombre'),
		));
		$this->set(compact('modelos', 'marca', 'tiposFallas'));
	}
	public function listado($idMarca, $idModelo){
		$this->loadModel('Falla');
		$this->loadModel('ComentarioFalla');

		$this->Paginator->settings = array(
			'fields' => array('Falla.descripcion', 'Falla.created', 'Falla.titulo', 'Falla.id', 'Falla.tipo_comentario', 'Falla.nick'),
			'conditions' => array('Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca),
			'contain' => array(
				'User' => array(
					'Persona'
				), 
				'Vehiculo',
				'TipoFalla' => array(
					'fields' => array('nombre')
				)
			),
			'limit' => 10,
			'order' => 'Falla.created DESC'
		);
		$fallas = $this->Paginator->paginate('Falla');

		foreach ($fallas as $key => $falla) {
			$comentarioFalla = $this->ComentarioFalla->find('all', array(
				'fields' => array('count(*) as numero'),
				'conditions' => array('Falla.id' => $falla['Falla']['id'])
			));
			$fallas[$key]['Falla']['numero'] = $comentarioFalla[0][0]['numero'];
		}
		$marca = $this->Falla->Vehiculo->Marca->find('first', array(
			'fields' => array('Marca.id', 'Marca.nombre'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$modelo = $this->Falla->Vehiculo->Modelo->find('first', array(
			'fields' => array('Modelo.id', 'Modelo.nombre'),
			'conditions' => array('Modelo.id' => $idModelo)
		));
		if(empty($modelo)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'modelo', 'action' => 'index', $idMarca));
		}

		$anuncio = $this->Falla->User->Cliente->Anuncio->random();

		$this->set(compact('fallas', 'modelo', 'marca', 'anuncio'));
	}
	public function detalle($idMarca, $idModelo, $idFalla){
		$this->loadModel('ComentarioFalla');

		$marca = $this->ComentarioFalla->Falla->Vehiculo->Marca->find('first', array(
			'fields' => array('Marca.id', 'Marca.nombre'),
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$modelo = $this->ComentarioFalla->Falla->Vehiculo->Modelo->find('first', array(
			'fields' => array('Modelo.id', 'Modelo.nombre'),
			'conditions' => array('Modelo.id' => $idModelo)
		));
		if(empty($modelo)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'modelo', 'action' => 'index', $idMarca));
		}

		$falla = $this->ComentarioFalla->Falla->find('first', array(
			'conditions' => array('Falla.id' => $idFalla),
			'contain' => array(
				'Vehiculo' => array(
					'Marca',
					'Modelo'
				),
				'TipoFalla',
				'User' => array(
					'Persona'
				)
			)
		));
		if(empty($falla)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'falla', 'action' => 'listado', $idMarca, $idModelo));
		}
		$comentarios = $this->ComentarioFalla->find('all', array(
			'conditions' => array('ComentarioFalla.id_falla' => $idFalla),
			'contain' => array(
				'User' => array(
					'Persona',
					'Cliente'
				)
			),
			'order' => 'ComentarioFalla.created DESC'
		));
		$anuncio = $this->Falla->User->Cliente->Anuncio->random();

		$this->set(compact('falla', 'comentarios', 'anuncio'));
	}
	public function add_comentario($idMarca, $idModelo, $idFalla){
		$this->AutoRender = false;
		$this->loadModel('ComentarioFalla');

		if(!empty($this->data)){
			$comentario = array();
			$comentario['id_falla'] = $idFalla;
			$comentario['id_usuario'] = $this->Session->read('Auth.User.id'); 
			$comentario['descripcion'] = $this->data['ComentarioFalla']['descripcion'];
			if($this->ComentarioFalla->save($comentario)){		
				$this->Session->setFlash(__('Gracias por Comentar'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Comentario no se pudo guardar, intente otra vez'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
			$this->redirect(array('controller' => 'falla', 'action' => 'detalle', $idMarca, $idModelo, $idFalla));
		}
	}
	public function denunciar($idMarca, $idModelo, $idFalla) {
		$this->AutoRender = false;
		$this->loadModel('DenunciaFalla');
		$idUsuario = $this->Session->read('Auth.User.id');

		if(empty($idUsuario)){
			$this->Session->setFlash(__('Inicie sesión para poder denunciar'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'falla', 'action' => 'detalle', $idMarca, $idModelo, $idFalla));
		}else {
			$misFallas = $this->DenunciaFalla->find('first', array(
				'conditions' => array(
					'DenunciaFalla.id_usuario' => $idUsuario,
					'DenunciaFalla.id_falla' => $idFalla
				),
				'fields' => array('DenunciaFalla.id')
			));
			if(!empty($misFallas)){
				$this->Session->setFlash(__('Ud ya denuncio esta opinión'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect(array('controller' => 'falla', 'action' => 'detalle', $idMarca, $idModelo, $idFalla));
			}else{
				$denuncia = array(
					'id_usuario' => $idUsuario,
					'id_falla' => $idFalla
				);
				$this->DenunciaFalla->save($denuncia);

				$denuncias = $this->DenunciaFalla->find('all', array(
					'conditions' => array('DenunciaFalla.id_falla' => $idFalla),
					'fields' => array('id')
				));

				if(count($denuncias) == 5){
					$this->DenunciaFalla->Falla->delete($idFalla);
					$this->Session->setFlash(__('Gracias por su participación!'), 'default', array('class' => 'alert alert-success alert-index'));
					$this->redirect(array('controller' => 'falla', 'action' => 'listado', $idMarca, $idModelo));
				}
				$this->Session->setFlash(__('Gracias por su participación!'), 'default', array('class' => 'alert alert-success alert-index'));
				$this->redirect(array('controller' => 'falla', 'action' => 'detalle', $idMarca, $idModelo, $idFalla));
			}
		}
	}
}
?>
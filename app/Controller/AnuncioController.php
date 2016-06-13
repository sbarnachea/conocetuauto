<?php 
class AnuncioController extends AppController {
		
	public function index(){
		$this->loadModel('Anuncio');
		$anuncios = $this->Anuncio->find('all', array(
			'conditions' => array('Anuncio.id_cliente' => $this->Session->read('Auth.User.Cliente.id')),
			'order' => 'Anuncio.estado ASC'
		));

		$this->set(compact('anuncios'));
	}
	public function detalle($idCliente, $idAnuncio){
		$this->loadModel('Anuncio');

		$cliente = $this->Anuncio->Cliente->find('first', array(
			'conditions' => array('Cliente.id' => $idCliente)
		));
		if(empty($cliente)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca'));
		}

		$anuncio = $this->Anuncio->find('first', array(
			'conditions' => array('Anuncio.id' => $idAnuncio, 'Anuncio.id_cliente' => $idCliente, 'Anuncio.estado' => 1)
		));
		if(empty($anuncio)){
			$this->Session->setFlash(__('Anuncio no existe, finalizó o aún no se aprueba'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca'));
		}

		$this->set(compact('anuncio', 'cliente'));
	}
	public function add(){
		$this->loadModel('Anuncio');

		if(!empty($this->data)){
			$anuncio = array();
			$anuncio['titulo'] = $this->data['Anuncio']['titulo'];
			$anuncio['descripcion'] = $this->data['Anuncio']['descripcion'];

			$anuncio['imagen'] = $this->data['Anuncio']['imagen']['name'];
			$anuncio['imagen_horizontal'] = $this->data['Anuncio']['imagen_horizontal']['name'];
			$anuncio['id_cliente'] = (int) $this->Session->read('Auth.User.Cliente.id');
			$anuncio['estado'] = 0;
			$anuncio['fecha_inicio'] = date('Y-m-d');

			define ('SITE_ROOT', realpath(dirname(__FILE__)));
			$nombrearchivo = SITE_ROOT . '/vendors/img/anuncio/' . $this->data['Anuncio']['imagen']['name'];
			$nombrearchivo = explode('/app/Controller', $nombrearchivo);
			$nombre = $nombrearchivo[0] . $nombrearchivo[1];

			$nombrearchivo2 = SITE_ROOT . '/vendors/img/anuncio/' . $this->data['Anuncio']['imagen_horizontal']['name'];
			$nombrearchivo2 = explode('/app/Controller', $nombrearchivo2);
			$nombre2 = $nombrearchivo2[0] . $nombrearchivo2[1];
			
			if($this->Anuncio->save($anuncio)){		
				if (move_uploaded_file($this->data['Anuncio']['imagen']['tmp_name'],$nombre) && move_uploaded_file($this->data['Anuncio']['imagen_horizontal']['tmp_name'],$nombre2)) {
					$this->Session->setFlash(__('Publicidad agregada exitosamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
			}else{
				$this->Session->setFlash(__('Publicidad no agregada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}

			$this->redirect(array('controller' => 'anuncio', 'action' => 'index'));
		}
	}
	public function edit($idAnuncio){
		$this->loadModel('Anuncio');

		if(!empty($this->data)){
			$anuncio = array();
			$anuncio['id'] = $this->data['Anuncio']['id'];
			$anuncio['titulo'] = $this->data['Anuncio']['titulo'];
			$anuncio['descripcion'] = $this->data['Anuncio']['descripcion'];

			define ('SITE_ROOT', realpath(dirname(__FILE__)));

			if(!empty($this->data['Anuncio']['imagen']['name'])){
				$anuncio['imagen'] = $this->data['Anuncio']['imagen']['name'];

				$nombrearchivo = SITE_ROOT . '/vendors/img/anuncio/' . $this->data['Anuncio']['imagen']['name'];
				$nombrearchivo = explode('/app/Controller', $nombrearchivo);
				$nombre = $nombrearchivo[0] . $nombrearchivo[1];
			}
			if(!empty($this->data['Anuncio']['imagen_horizontal']['name'])){
				$anuncio['imagen_horizontal'] = $this->data['Anuncio']['imagen_horizontal']['name'];

				$nombrearchivo2 = SITE_ROOT . '/vendors/img/anuncio/' . $this->data['Anuncio']['imagen_horizontal']['name'];
				$nombrearchivo2 = explode('/app/Controller', $nombrearchivo2);
				$nombre2 = $nombrearchivo2[0] . $nombrearchivo2[1];
			}	
			
			if($this->Anuncio->save($anuncio)){		
				if(!empty($this->data['Anuncio']['imagen']['name'])){
					move_uploaded_file($this->data['Anuncio']['imagen']['tmp_name'],$nombre);
				}
				if(!empty($this->data['Anuncio']['imagen_horizontal']['name'])){
					move_uploaded_file($this->data['Anuncio']['imagen_horizontal']['tmp_name'],$nombre2);
				}
				
				$this->Session->setFlash(__('Publicidad agregada exitosamente'), 'default', array('class' => 'alert alert-info alert-index'));
			}else{
				$this->Session->setFlash(__('Publicidad no agregada, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}

			$this->redirect(array('controller' => 'anuncio', 'action' => 'index'));
		}
		$anuncio = $this->Anuncio->find('first', array(
			'conditions' => array('Anuncio.id' => $idAnuncio)
		));

		$this->set(compact('anuncio'));
	}
	public function delete($idAnuncio){
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
			$this->redirect(array('controller' => 'anuncio', 'action' => 'index'));
		}
	}
	public function renovar($idAnuncio){
		$this->loadModel('Anuncio');
		$anuncio = $this->Anuncio->find('first', array(
			'conditions' => array('Anuncio.id' => $idAnuncio)
		));
		if(empty($anuncio)){
			$this->Session->setFlash(__('No existe Anuncio'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'anuncio', 'action' => 'index'));
		}
		$renovar = array();
		$renovar['id'] = $idAnuncio;
		$renovar['estado'] = 0;
		if($this->Anuncio->save($renovar)){		
			$this->Session->setFlash(__('Anuncio renovado'), 'default', array('class' => 'alert alert-info alert-index'));
		}else{
			$this->Session->setFlash(__('Ocurrio un problema, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
		}
		$this->redirect(array('controller' => 'anuncio', 'action' => 'index'));
	}
}
?>
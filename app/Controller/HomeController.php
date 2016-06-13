<?php 
class HomeController extends AppController {
		
	public function index(){
		$this->loadModel('Valoracion');
		$this->loadModel('Marca');

		$ranking = $this->Valoracion->ranking();

		$marcas = $this->Marca->find('all', array(
			'fields' => array('imagen', 'nombre', 'id'),
			'conditions' => array('portada' => 1),
			'limit' => 4
		));
		$talleres = $this->Valoracion->Cliente->find('all');
		
		$this->set(compact('ranking', 'marcas', 'talleres'));
	}
	public function empresas(){
		
	}
	public function prueba(){
		$this->layout = 'ajax';
	}
	public function encuesta(){
		$this->layout = 'encuesta';	
		$this->loadModel('Falla');

		if(!empty($this->data)){
			if($this->Falla->Vehiculo->save($this->data['Vehiculo'])){

				$this->request->data['Falla']['id_vehiculo'] = $this->Falla->Vehiculo->id;
				$this->request->data['Falla']['fuente'] = 1;
				if($this->Falla->save($this->data['Falla'])){		
					$this->Session->setFlash(__('Gracias por compartir tu experiencia con nosotros'), 'default', array('class' => 'alert alert-info alert-index'));
					$this->redirect(array('controller' => 'home', 'action' => 'encuesta'));
				}else{
					$this->Session->setFlash(__('Ocurrio un problema, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
				}
			}else{
				$this->Session->setFlash(__('Ocurrio un problema, favor intente nuevamente'), 'default', array('class' => 'alert alert-danger alert-index'));
			}
		}

		$marcas = $this->Falla->Vehiculo->Marca->find('list', array(
			'fields' => array('Marca.id', 'Marca.nombre'),
			'order' => 'Marca.nombre ASC'
		));

		$tiposFallas = $this->Falla->TipoFalla->find('list', array(
			'fields' => array('TipoFalla.id', 'TipoFalla.nombre'),
			'order' => 'TipoFalla.nombre ASC'
		));
		$this->set(compact('marcas', 'tiposFallas'));
	}
	public function get_modelos($idMarca){
		$this->AutoRender = false;
		$this->layout = 'ajax';
		$this->loadModel('Modelo');

		$modelosD = $this->Modelo->find('all', array(
			'fields' => array('id', 'nombre'),
			'conditions' => array('Modelo.id_marca' => $idMarca),
			'order' => 'Modelo.nombre ASC'
		));

		$modelos = array();
		foreach($modelosD as $modelo){
			$modelos[$modelo['Modelo']['id']] = ucwords($modelo['Modelo']['nombre']);
		}

		$this->set(compact('modelos'));
	}
}
?>
<?php 
class ModeloController extends AppController {
		
	public function index($idMarca){
		$this->loadModel('Falla');

		$marca = $this->Falla->Vehiculo->Marca->find('first', array(
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$marca = $this->Falla->Vehiculo->Marca->find('first', array(
			'fields' => array('nombre', 'id', 'imagen'),
			'conditions' => array('id' => $idMarca)
		));

		$modelos = $this->Falla->Vehiculo->Modelo->find('all', array(
			'fields' => array('nombre', 'id'),
			'conditions' => array('id_marca' => $idMarca)
		));

		$modelosfallas = $this->Falla->find('all', array(
			'fields' => array('count(*) as numero', 'Vehiculo.id_modelo', 'Vehiculo.id_marca'),
			'conditions' => array('Vehiculo.id_marca' => $idMarca),
			'group' => 'Vehiculo.id_modelo',
			'order' => 'numero DESC',
			'limit' => 4
		));

		$masfallados = array();
		foreach($modelosfallas as $key => $modelo){
			$masfallados[$key]['numero'] = $modelo[0]['numero'];
			$masfallados[$key]['id_modelo'] = $modelo['Vehiculo']['id_modelo'];
			$masfallados[$key]['id_marca'] = $modelo['Vehiculo']['id_marca'];
			$modelo = $this->Falla->Vehiculo->Modelo->find('first', array('fields' => array('nombre'), 'conditions' => array('Modelo.id' => $modelo['Vehiculo']['id_modelo'])));
			$masfallados[$key]['nombre'] = $modelo['Modelo']['nombre'];
		}
		$this->set(compact('marca', 'modelos', 'masfallados'));
	}
	public function detalle($idMarca, $idModelo){
		$this->loadModel('ComentarioFalla');

		$marca = $this->ComentarioFalla->Falla->Vehiculo->Marca->find('first', array(
			'conditions' => array('Marca.id' => $idMarca)
		));
		if(empty($marca)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'marca', 'action' => 'index'));
		}

		$modelo = $this->ComentarioFalla->Falla->Vehiculo->Modelo->find('first', array(
			'conditions' => array('Modelo.id' => $idModelo, 'Modelo.id_marca' => $idMarca),
			'contain' => array('Marca')
		));
		if(empty($modelo)){
			$this->Session->setFlash(__('URL Incorrecta'), 'default', array('class' => 'alert alert-danger alert-index'));
			$this->redirect(array('controller' => 'modelo', 'action' => 'index', $idMarca));
		}

		$tiposFallas =  $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('TipoFalla.nombre', 'Vehiculo.id_modelo', 'Vehiculo.id_marca', 'count(*) as numero'),
			'conditions' => array('Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca, 'Falla.tipo_comentario' => 1),
			'limit' => 10,
			'order' => 'numero DESC',
			'group' => 'TipoFalla.nombre'
		));

		$anoVehiculo = $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('count(*) as total', 'Vehiculo.ano', 'Vehiculo.id'),
			'conditions' => array('Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca, 'Falla.tipo_comentario' => 1),
			'order' => 'total DESC',
			'group' => 'Vehiculo.ano'
		));

		$total = $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('count(*) as personas'),
			'conditions' => array('Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca)
		));

		$fallas =  $this->ComentarioFalla->Falla->find('all', array(
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
			'limit' => 5,
			'order' => 'Falla.created DESC'
		));
		$fallasPositiva = $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('tipo_comentario' => 0, 'Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca)
		));
		$fallasNegativa = $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('count(*) as total'),
			'conditions' => array('tipo_comentario' => 1, 'Vehiculo.id_modelo' => $idModelo, 'Vehiculo.id_marca' => $idMarca)
		));
		$anuncio = $this->ComentarioFalla->Falla->User->Cliente->Anuncio->random();

		foreach ($fallas as $key => $falla) {
			$comentarioFalla = $this->ComentarioFalla->find('all', array(
				'fields' => array('count(*) as numero'),
				'conditions' => array('Falla.id' => $falla['Falla']['id'])
			));
			$fallas[$key]['Falla']['numero'] = $comentarioFalla[0][0]['numero'];
		}

		$this->set(compact('modelo', 'tiposFallas', 'anoVehiculo', 'total', 'fallas', 'fallasPositiva', 'fallasNegativa', 'anuncio'));
	}
}
?>
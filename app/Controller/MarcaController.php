<?php 
class MarcaController extends AppController {
		
	public function index(){
		$this->loadModel('Marca');

		$marcasPortada = $this->Marca->find('all', array(
			'fields' => array('imagen', 'nombre', 'id'),
			'conditions' => array('portada' => 1)
		));

		$marcas = $this->Marca->find('all', array(
			'fields' => array('imagen', 'nombre', 'id'),
			'conditions' => array('portada !=' => 1)
		));

		$this->set(compact('marcasPortada', 'marcas'));
	}
}
?>
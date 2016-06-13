<?php

class Anuncio extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');

	public $belongsTo = array(
		'Cliente' => array(
			'foreignKey' => 'id_cliente'
		)
	);

	public function random(){
		$anuncios = $this->find('all', array(
			'conditions' => array('Anuncio.estado' => 1),
			'order' => 'rand()',
			'limit' => 15
		));

		$anuncio = array();

		if(!empty($anuncios)){
			$keys = array_keys($anuncios);
			shuffle($keys);
			$anuncio = $anuncios[$keys[0]];
		}

		return $anuncio;
	}
}
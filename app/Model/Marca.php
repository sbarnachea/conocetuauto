<?php

class Marca extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');

	public $hasMany = array(
		'Modelo' => array(
			'className' => 'Modelo',
			'foreignKey' => 'id_marca'
		)
	);
}
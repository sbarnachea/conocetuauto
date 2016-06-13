<?php

class Falla extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');
	
	public $belongsTo = array(
		'Vehiculo' => array(
			'foreignKey' => 'id_vehiculo'
		),
		'TipoFalla' => array(
			'foreignKey' => 'id_tipo_falla'
		),
		'User' => array(
			'foreignKey' => 'id_usuario'
		)
	);

	public $hasMany = array(
		'DenunciaFalla' => array(
			'className' => 'DenunciaFalla',
			'foreignKey' => 'id_falla'
		)
	);
	
}
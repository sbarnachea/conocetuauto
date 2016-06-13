<?php

class Cliente extends AppModel {
	var $actsAs = array('SoftDelete','MeioUpload' => array('imagen'), 'Containable');
	
	public $belongsTo = array(
		'User' => array(
			'foreignKey' => 'id_usuario'
		),
		'Correo' => array(
			'foreignKey' => 'id_correo'
		),
		'Region' => array(
			'foreignKey' => 'id_region'
		),
		'Provincia' => array(
			'foreignKey' => 'id_provincia'
		),
		'Comuna' => array(
			'foreignKey' => 'id_comuna'
		)
	);
	public $hasMany = array(
		'Valoracion' => array(
			'className' => 'Valoracion',
			'foreignKey' => 'id_cliente'
		),
		'Anuncio' => array(
			'className' => 'Anuncio',
			'foreignKey' => 'id_cliente'
		)
	);
}
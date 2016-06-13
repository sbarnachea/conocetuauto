<?php

class DenunciaFalla extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');
	
	public $belongsTo = array(
		'Falla' => array(
			'foreignKey' => 'id_falla'
		),
		'User' => array(
			'foreignKey' => 'id_usuario'
		)
	);
	
}
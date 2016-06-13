<?php

class Persona extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');

    public $belongsTo = array(
    	'User' => array(
    		'foreignKey' => 'id_usuario'
    	),
    	'Correo' => array(
    		'foreignKey' => 'id_correo'
    	)
    );
    
}
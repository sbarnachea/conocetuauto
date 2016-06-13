<?php

class Vehiculo extends AppModel {
    var $actsAs = array('SoftDelete', 'Containable');
    
	public $belongsTo = array(
    	'Marca' => array(
    		'foreignKey' => 'id_marca'
    	),
    	'Modelo' => array(
    		'foreignKey' => 'id_modelo'
    	)
    );
    
}
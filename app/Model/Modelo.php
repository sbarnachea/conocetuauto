<?php

class Modelo extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');

	public $belongsTo = array(
    	'Marca' => array(
    		'foreignKey' => 'id_marca'
    	),
    	'TipoVehiculo' => array(
    		'foreignKey' => 'id_tipo_vehiculo'
    	)
    );
    
}
<?php

class Comuna extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');
	
	public $belongsTo = array(
    	'Provincia' => array(
    		'foreignKey' => 'id_provincia'
    	)
    );
    
}
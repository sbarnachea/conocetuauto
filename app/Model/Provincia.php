<?php

class Provincia extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');

	public $belongsTo = array(
    	'Region' => array(
    		'foreignKey' => 'id_region'
    	)
    );
    
}
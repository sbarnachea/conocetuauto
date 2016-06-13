<?php
App::uses('AuthComponent', 'Controller/Component');
 
class User extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');
	
    public $belongsTo = array(
    	'TipoUsuario' => array(
    		'foreignKey' => 'id_tipo_usuario'
    	)
    );
 	
	public $hasMany = array(
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'id_usuario'
		),
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'id_usuario'
		),
		'DenunciaFalla' => array(
			'className' => 'DenunciaFalla',
			'foreignKey' => 'id_usuario'
		)
	);
}
?>
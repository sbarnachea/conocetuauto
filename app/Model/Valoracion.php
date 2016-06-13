<?php

class Valoracion extends AppModel {
	var $actsAs = array('SoftDelete', 'Containable');
	
	public $useTable = 'valoraciones';

	public $belongsTo = array(
		'Cliente' => array(
			'foreignKey' => 'id_cliente'
		),
		'User' => array(
			'foreignKey' => 'id_usuario'
		)
	);
	
	public function ranking(){
		$votaciones = $this->find('all', array(
			'fields' => array('sum(estrellas) as votos', 'count(Valoracion.id) as numero', 'avg(estrellas) as promedio', 'id_cliente', 'Cliente.nombre','Cliente.direccion','Cliente.telefono', 'Cliente.imagen', 'Cliente.id_correo', 'Cliente.id_comuna'),
			'group' => 'Cliente.nombre',
			'order' => 'promedio DESC',
			'limit' => 3
		));

		$ranking = array();
		foreach ($votaciones as $key => $votacion) {
			$ranking[$key]['Cliente']['nombre'] = $votacion['Cliente']['nombre'];
			$ranking[$key]['Cliente']['id'] = $votacion['Valoracion']['id_cliente'];
			$ranking[$key]['Cliente']['direccion'] = $votacion['Cliente']['direccion'];
			$ranking[$key]['Cliente']['telefono'] = $votacion['Cliente']['telefono'];
			$ranking[$key]['Cliente']['id_correo'] = $votacion['Cliente']['id_correo'];
			$ranking[$key]['Cliente']['id_comuna'] = $votacion['Cliente']['id_comuna'];
			$ranking[$key]['Cliente']['imagen'] = $votacion['Cliente']['imagen'];
			$ranking[$key]['estrellas_totales'] = $votacion[0]['votos'];
			$ranking[$key]['numero'] = $votacion[0]['numero'];
			$ranking[$key]['promedio'] = round($votacion[0]['promedio']);
		}

		return $ranking;
	}
}
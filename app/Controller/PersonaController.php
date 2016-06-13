<?php 
class PersonaController extends AppController {
		
	public function perfil(){
		$this->loadModel('Persona');
		$this->loadModel('ComentarioFalla');

		if(!empty($this->data['Persona'])){
			$correo = array();
			$correo['Correo']['id'] = $this->data['Correo']['id'];
			$correo['Correo']['direccion'] = $this->data['Correo']['direccion'];
			$proveedor = explode('@', $this->data['Correo']['direccion']);
			$correo['Correo']['proveedor'] = $proveedor[1];

			if($this->Persona->Correo->save($correo)){
				if($this->Persona->save($this->data['Persona'])){
					$this->Session->setFlash(__('Perfil editado correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Perfil no editado, intente nuevamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
				$this->redirect(array('controller' => 'perfil'));
			}
		}
		if(!empty($this->data['User'])){
			if($this->data['User']['password'] != $this->data['User']['password2']){
				$this->Session->setFlash('Contraseñas no coinciden', 'default', array('class' => 'alert alert-danger alert-index'));
			}else{
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
				if($this->Persona->User->save($this->data['User'])){
					$this->Session->setFlash(__('Contraseña editada correctamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}else{
					$this->Session->setFlash(__('Contraseña no editada, intente nuevamente'), 'default', array('class' => 'alert alert-info alert-index'));
				}
				$this->redirect(array('controller' => 'perfil'));
			}
		}
		$fallas =  $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('Falla.descripcion', 'Falla.created', 'Falla.titulo', 'Falla.id', 'Falla.tipo_comentario', 'Falla.nick'),
			'conditions' => array('Falla.id_usuario' => $this->Session->read('Auth.User.id')),
			'contain' => array(
				'User' => array(
					'Persona'
				), 
				'Vehiculo' => array(
					'fields' => array('Vehiculo.id_marca', 'Vehiculo.id_modelo'),
					'Modelo',
					'Marca'
				),
				'TipoFalla' => array(
					'fields' => array('nombre')
				)
			),
			'limit' => 4,
			'page' => 1,
			'order' => 'Falla.created DESC'
		));
		foreach ($fallas as $key => $falla) {
			$comentarioFalla = $this->ComentarioFalla->find('all', array(
				'fields' => array('count(*) as numero'),
				'conditions' => array('Falla.id' => $falla['Falla']['id'])
			));
			$fallas[$key]['Falla']['numero'] = $comentarioFalla[0][0]['numero'];
		}
		$persona = $this->Persona->find('first', array(
			'conditions' => array('Persona.id' => $this->Session->read('Auth.User.Persona.id'))
		));

		$this->set(compact('persona', 'fallas'));
	}
	public function get_comentarios($page){
		$this->loadModel('ComentarioFalla');
		$this->layout = 'ajax';

		$fallas =  $this->ComentarioFalla->Falla->find('all', array(
			'fields' => array('Falla.descripcion', 'Falla.created', 'Falla.titulo', 'Falla.id', 'Falla.tipo_comentario', 'Falla.nick'),
			'conditions' => array('Falla.id_usuario' => $this->Session->read('Auth.User.id')),
			'contain' => array(
				'User' => array(
					'Persona'
				), 
				'Vehiculo' => array(
					'fields' => array('Vehiculo.id_marca', 'Vehiculo.id_modelo'),
					'Modelo',
					'Marca'
				),
				'TipoFalla' => array(
					'fields' => array('nombre')
				)
			),
			'limit' => 4,
			'page' => $page,
			'order' => 'Falla.created DESC'
		));
		foreach ($fallas as $key => $falla) {
			$comentarioFalla = $this->ComentarioFalla->find('all', array(
				'fields' => array('count(*) as numero'),
				'conditions' => array('Falla.id' => $falla['Falla']['id'])
			));
			$fallas[$key]['Falla']['numero'] = $comentarioFalla[0][0]['numero'];
		}

		$this->set(compact('fallas'));
	}
}
?>
<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
// app/Controller/AppController.php
class AppController extends Controller {
	
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'marca', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
			'authError' => 'Tienes que Ingresar para ver la página',
			'loginError' => 'Usuario o Contraseña invalida, intentelo otra vez'
		)
	);

	public function beforeFilter() {
		switch ($this->name) {
			case 'Home':
				$this->Auth->allow('index', 'empresas', 'encuesta', 'get_modelos');
				break;  
			case 'Marca':
				$this->Auth->allow('index');
				break;
			case 'Modelo':
				$this->Auth->allow('index', 'detalle');
			case 'Falla':
				$this->Auth->allow('listado', 'detalle');
			case 'Cliente':
				$this->Auth->allow('listado', 'detalle');
			case 'Anuncio':
				$this->Auth->allow('detalle');
				break;
		}
		$user = $this->Session->read('Auth.User'); 

		if(!empty($user)){
			$controller = $this->params['controller'];
			$action = $this->params['action']; 
			
			$this->loadModel('Persona');
			$persona = $this->Persona->find('first', array('conditions' => array('Persona.id_usuario' => $user['id'])));
			if(empty($persona)){
				$this->loadModel('Cliente');
				$cliente = $this->Cliente->find('first', array('conditions' => array('Cliente.id_usuario' => $user['id'])));
				$this->Session->write('Auth.User.Cliente', $cliente['Cliente']);
			}else{
				$this->Session->write('Auth.User.Persona', $persona['Persona']);
			}
			if($controller == 'anuncio' && $user['id_tipo_usuario'] != 2 && $action != 'detalle'){
				$this->Session->setFlash(__('Permisos insuficientes para acceder a esta página'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect(array('controller' => 'marca', 'action' => 'index'));
			}
			if($controller == 'cliente' && $user['id_tipo_usuario'] == 2 && $action == 'votar'){
				$this->Session->setFlash(__('Su perfil no puede votar por un taller'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect($this->referer());
			}
			if($controller == 'falla' && $user['id_tipo_usuario'] == 2 && ($action == 'add' || $action == 'elegir_modelo')){
				$this->Session->setFlash(__('Su perfil no puede ingresar fallas'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect($this->referer());
			}
			if($controller == 'admin' && $user['id_tipo_usuario'] != 3){
				$this->Session->setFlash(__('Permisos insuficientes para acceder a esta página'), 'default', array('class' => 'alert alert-danger alert-index'));
				$this->redirect(array('controller' => 'marca', 'action' => 'index'));
			}
		}
	}
}

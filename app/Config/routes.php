<?php
App::uses('CakeSession', 'Model/Datasource');
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'home', 'action' => 'index'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/registro', array('controller' => 'users', 'action' => 'add'));
	Router::connect('/empresas', array('controller' => 'home', 'action' => 'empresas'));
	Router::connect('/talleres', array('controller' => 'cliente', 'action' => 'listado'));
	$tipo_usuario = CakeSession::read('Auth.User.id_tipo_usuario');
	if($tipo_usuario == 3 || $tipo_usuario == 1){
		Router::connect('/perfil', array('controller' => 'persona', 'action' => 'perfil'));
	}elseif($tipo_usuario == 2){
		Router::connect('/perfil', array('controller' => 'cliente', 'action' => 'perfil'));
	}
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

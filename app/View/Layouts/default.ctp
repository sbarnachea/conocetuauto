<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<link rel="shortcut icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">
	<title>Conoce tu auto</title>
	<meta property="og:title" content="Conoce tu auto">
	<meta property="og:description" content="Comunidad para compartir la experiencia de nuestros vehiculos, comparte tu experiencia con nosotros y obten estadisticas de los vehiculos">
	<meta property="og:image" content="<?php echo Configure::read('App.staticUrl') . 'img/icono-fb.png'; ?>">
	<meta property="og:image:type" content="image/png">
	<meta property="og:url" content="http://conocetuauto.cl">
	<?php
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/reset.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/bootstrap-3.1.1.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/app.css');

		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/jquery-1.8.3.min.js');
		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/jquery.autosize.min.js');
		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/Chart.min.js');
		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/bootstrap.min.js');
		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/app.js');
	?>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
</head>
<body>
	<div id="container">
		<div class="navbar-menu">
			<div class="wrapper">
				<div class="logo">
					<?php 
					$clase = '';
					if($this->params['controller'] == 'home'){
						$clase = 'hide';
					}
					echo $this->Html->link($this->Html->image(Configure::read('App.staticUrl') . 'img/logo.png', array('class' => $clase)), $this->Html->url(array('controller' => 'home', 'action' => 'index')), array('escape' => false)); ?>
				</div>
				<div class="social pull-left">
					<?php echo $this->Html->link('<i class="fa fa-envelope"></i>', 'mailto:contacto@conocetuauto.cl', array('class' => 'item pull-left', 'escape' => false, 'target' => '_blank')); ?>
					<?php echo $this->Html->link('<i class="fa fa-facebook"></i>', 'https://www.facebook.com/conocetuautochile', array('class' => 'item pull-left', 'escape' => false, 'target' => '_blank')); ?>
					<?php echo $this->Html->link('<i class="fa fa-twitter"></i>', 'https://twitter.com/conocetuautocl', array('class' => 'item pull-left', 'escape' => false, 'target' => '_blank')); ?>
					<div class="clearfix"></div>
				</div>
				
				<div class="acciones pull-right">
					<?php 
					if(!$this->Session->check('Auth.User')){
						echo $this->Html->link('Ingresar', $this->Html->url(array('controller' => 'login')));
						echo $this->Html->link('Regístrate', $this->Html->url(array('controller' => 'registro')), array('class' => 'btn-header'));
						echo $this->Html->link('<i class="fa fa-car"></i> Talleres', $this->Html->url(array('controller' => 'empresas')), array('escape' => false, 'class' => 'btn-header'));
					}else{
						if($this->Session->check('Auth.User.Persona')){
							$nombre = $this->Session->read('Auth.User.Persona.nombre') . ' ' . $this->Session->read('Auth.User.Persona.paterno');
						}else{
							$nombre = $this->Session->read('Auth.User.Cliente.nombre');
						}
						echo $this->Html->link($nombre . ' <i class="fa fa-chevron-down"></i>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)); ?>
						<ul class="dropdown-menu" role="menu">
							<li>
								<?php echo $this->Html->link('Mi Perfil', $this->Html->url(array('controller' => 'perfil')), array('escape' => false)); ?>
							</li>
							<?php if($this->Session->read('Auth.User.id_tipo_usuario') == 3){ ?>
								<li>
									<?php echo $this->Html->link('Administrador', $this->Html->url(array('controller' => 'admin')), array('escape' => false)); ?>
								</li>
								
							<?php } 
							if($this->Session->read('Auth.User.id_tipo_usuario') == 2){ ?>
								<li>
									<?php echo $this->Html->link('Mi Publicidad', $this->Html->url(array('controller' => 'anuncio', 'action' => 'index')), array('escape' => false)); ?>
								</li>
							<?php } ?>
								<li>
									<?php echo $this->Html->link('Salir', $this->Html->url(array('controller' => 'users', 'action' => 'logout'))); ?>
								</li>
						</ul>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="wrapper alertas">
				<div class="crumb">
					<?php echo $this->Html->getCrumbs(' / '); ?>
				</div>
				<?php echo $this->Session->flash(); ?>
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div class="footer">
			<div class="wrapper">
				<div class="info pull-left">
					<div class="pull-left item">
						<p>Nosotros</p>
						<ul>
							<li><a href="<?php echo $this->Html->url(array('controller' => 'home')); ?>">Inicio</a></li>
							<li><a href="<?php echo $this->Html->url(array('controller' => 'empresas')); ?>">Empresas</a></li>
						</ul>
					</div>
					<div class="pull-left ">
						<p>Redes Sociales</p>
						<ul>
							<li><a href="https://www.facebook.com/conocetuautochile" target='_blank'>Facebook</a></li>
							<li><a href="https://twitter.com/conocetuautocl" target='_blank'>Twitter</a></li>
							<li><a href="mailto:contacto@conocetuauto.cl" target='_blank'>Email</a></li>
						</ul>
					</div>
					<div class="pull-right">
						<?php echo  $this->Html->image(Configure::read('App.staticUrl') . 'img/logo.png', array()); ?>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
</body>
</html>

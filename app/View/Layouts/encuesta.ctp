<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<title>Conoce tu auto</title>
	<meta property="og:title" content="Conoce tu auto">
	<meta property="og:description" content="Responde esta pequeña encuesta y ayudanos a crear el mejor sitio de estadisticas automotrices">
	<meta property="og:image" content="<?php echo Configure::read('App.staticUrl') . 'img/icono-fb.png'; ?>">
	<meta property="og:image:type" content="image/png">
	<meta property="og:url" content="http://conocetuauto.cl">
	<link rel="shortcut icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">

	<?php
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/reset.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/bootstrap-3.1.1.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/encuesta.css');

		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/jquery-1.8.3.min.js');
		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/bootstrap.min.js');
	?>
</head>
<body>
	<div id="container">
		<div id="content">
			<div class="wrapper">
				<?php echo $this->Session->flash(); ?>
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<link rel="shortcut icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo Configure::read('App.staticUrl') . 'img/auto.png'; ?>" type="image/x-icon">
	<title>Conoce tu auto</title>
	<?php
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/reset.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/bootstrap-3.1.1.css');
		echo $this->Html->css(Configure::read('App.staticUrl') . 'css/login.css');

		echo $this->Html->script(Configure::read('App.staticUrl') . 'js/jquery-1.8.3.min.js');
	?>
</head>
<body>
	<?php echo $this->fetch('content'); ?>
</body>
</html>

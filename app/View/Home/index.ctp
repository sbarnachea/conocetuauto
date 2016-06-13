<div class="section1">
	<div class="wrapper">
		<div class="section1-a">
			<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/logo-principal.png'); ?>
		</div>
		<div class="section1-b">
			<div class="item pull-left">
				<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono1.png'); ?>				
				<p>Comparte la experiencia con tu auto</p>
			</div>
			<div class="item pull-left">
				<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono2.png'); ?>
				<p>Soluciona tu problema</p>
			</div>
			<div class="item pull-left">
				<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono3.png'); ?>
				<p>Obtén estadísticas de tu marca y/o modelo</p>
			</div>
			<div class="item pull-left">
				<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono4.png'); ?>
				<p>Conoce los mejores talleres de tu ciudad</p>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="section2">
	<div class="wrapper">
		<div class="separator"></div>
		<div class="section2-a">
			<h2>Empecemos ¿Cuál es tu auto?</h2>
			<div class="lista-autos">
				<?php foreach($marcas as $marca){ ?>
					<div class="item pull-left">
						<?php echo $this->Html->link($this->Html->image(Configure::read('App.staticUrl') . 'img/marca/resize/' . $marca['Marca']['imagen']),$this->Html->url(array('controller' => 'modelo', 'action' => 'index', $marca['Marca']['id'])), array('escape' => false)); ?>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
				<div class="otra">
					<?php echo $this->Html->link('Otra Marca',$this->Html->url(array('controller' => 'marca', 'action' => 'index'))); ?>
				</div>
				
			</div>
		</div>
	</div>
</div>
<div class="section3">
	<div class="wrapper">
		<div class="separator-blue"></div>
		<div class="section3-a">
			<h2>Ranking Mejores Talleres</h2>
			<div class="lista">
				<?php 
				if(empty($ranking)){ ?>
				<p>Aún no hay votaciones</p>
				<?php }
				$mejor = true;
				foreach($ranking as $taller){ ?>
					<a class="item pull-left" href="<?php echo $this->Html->url(array('controller' => 'cliente', 'action' => 'detalle', $taller['Cliente']['id'])); ?>">
						<?php 
							if($mejor)
								echo $this->Html->image(Configure::read('App.staticUrl') . 'img/mejor.png', array('class' => 'best')); 
						?>
						<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/'. (!empty($taller['Cliente']['imagen'])? $taller['Cliente']['imagen']: 'taller.jpg' )); ?>
						<p class="pull-left"><?php echo $taller['Cliente']['nombre']; ?></p>
						<?php for($i = 0; $i < $taller['promedio']; $i++){ ?>
							<i class="fa fa-star pull-left"></i>
						<?php } ?>
					</a>
					<?php 
					$mejor = false;
				} ?>
			</div>
			<div class="clearfix"></div>
			<div class="ver">
				<?php echo (!empty($talleres)? $this->Html->link('Ver talleres',$this->Html->url(array('controller' => 'talleres'))): ''); ?>
			</div>
		</div>
	</div>
</div>
<div class="section4">
	<div class="wrapper">
		<div class="separator"></div>
		<?php if(!$this->Session->check('Auth.User')){ ?> 
			<div class="section4-a pull-left">
				<h2>Regístrate</h2>
				<?php 
				echo $this->Form->create('User', array(
						'url' => array('controller' => 'users', 'action' => 'add'),
						'class' => array('form-signin'),
						'autocomplete' => 'off'
					));
					echo $this->Form->input('PreUser.username', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false));
					echo $this->Form->input('PreUser.password', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Contraseña', 'required' => true, 'label' => false));
					echo $this->Form->input('PreUser.email', array('class' => 'form-control', 'type' => 'email', 'placeholder' => 'Email', 'required' => true, 'label' => false));
				echo $this->Form->end(array('label' => 'Regístrate','class' => 'btn btn-primary pull-right')); 
				echo $this->Html->link('ya tengo cuenta',$this->Html->url(array('controller' => 'login')), array('class' => 'pull-right')); ?>
			</div> 
		<?php }else{ ?>
			<div class="section4-a-false"></div>
		<?php } ?>
		
		<div class="section4-b pull-left">
			<h2>Nuestros servicios</h2>
			<div class="item pull-left active">
				<div class="header">
					<h3>Compartir Fallas</h3>
				</div>
				<div class="icon">
					<div class="separator-serv"></div>
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono1.png'); ?>
				</div>
			</div>
			<div class="item pull-left active">
				<div class="header">
					<h3>Soluciones</h3>
				</div>
				<div class="icon">
					<div class="separator-serv"></div>
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono2.png'); ?>
				</div>
			</div>
			<div class="item pull-left active">
				<div class="header">
					<h3>Estadísticas</h3>
				</div>
				<div class="icon">
					<div class="separator-serv"></div>
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono3.png'); ?>
				</div>
			</div>
			<div class="item pull-left active">
				<div class="header">
					<h3>Ranking de Talleres</h3>
				</div>
				<div class="icon">
					<div class="separator-serv"></div>
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/icono4.png'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
	var $win = $(window);
	var $pos = 240;
	$win.scroll(function () {
		if ($win.scrollTop() >= $pos)
			$('.navbar-menu .logo img').removeClass('hide');
		else {
			$('.navbar-menu .logo img').addClass('hide');
		}
	});
});
</script>
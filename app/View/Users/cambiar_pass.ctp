<div id="login">
	<div class="login-a">
		<h2>Cambiar Contraseña</h2>
	</div>
	<div class="login-b">
		<div class="separator-login"></div>
		<?php 
			echo $this->Session->flash();
			echo $this->Form->create(null, array(
					'url' => array('controller' => 'users', 'action' => 'cambiar_pass', $idUsuario),
					'class' => array('form-signin'),
					'autocomplete' => 'off'
				));
				echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Contraseña', 'required' => true, 'label' => false));
				echo $this->Form->input('password2', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Confirmar Contraseña', 'required' => true, 'label' => false));
			echo $this->Form->end(array('label' => 'Cambiar','class' => 'btn btn-primary pull-right')); 
		?>
		<div class="clearfix"></div>
	</div>
</div>
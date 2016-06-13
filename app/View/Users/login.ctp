<div id="login">
	<div class="login-a">
		<h2>Iniciar Sesión</h2>
	</div>
	<div class="login-b">
		<div class="separator-login"></div>
		<?php 
			$referer = $this->request->referer();
			if($this->request->referer() == Router::url(array('controller' => 'login'), true)){
				$referer = $this->Html->url(array('controller' => 'home', 'action' => 'index'));
			}
			echo $this->Session->flash();
			echo $this->Form->create(null, array(
					'url' => array('controller' => 'users', 'action' => 'login'),
					'class' => array('form-signin'),
					'autocomplete' => 'off'
				));
				echo $this->Form->input('username', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nombre de usuario', 'required' => true, 'autofocus' => true, 'label' => false));
				echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Contraseña', 'required' => true, 'label' => false));
			echo $this->Form->end(array('label' => 'Ingresar','class' => 'btn btn-primary pull-right')); 
			echo $this->Html->link('No tengo cuenta',$this->Html->url(array('controller' => 'registro')), array('class' => 'pull-left'));
			echo $this->Html->link('Cancelar',$referer, array('class' => 'pull-right'));
		?>
		<div class="clearfix"></div>
	</div>
</div>
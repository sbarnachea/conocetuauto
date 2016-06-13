<div id="login" class="registro">
	<div class="login-a">
		<h2>Registro</h2>
	</div>
	<div class="login-b">
		<div class="separator-login"></div>
		<?php 
			echo $this->Session->flash();
			echo $this->Form->create(null, array(
					'url' => array('controller' => 'users', 'action' => 'add'),
					'class' => array('form-signin'),
					'autocomplete' => 'off'
				)); ?>

				<table>
					<tr>
						<td>Tipo de Usuario</td>
						<td>
							<?php echo $this->Form->input('tipousuario', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false, 'options' => array(1 => 'Normal', 2 => 'Taller Mecánico'), 'empty' => 'Seleccionar')); ?>
						</td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td>
							<?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nombre', 'required' => true, 'label' => false)); ?>
						</td>
					</tr>
					<tr class="persona">
						<td>Apellido Paterno</td>
						<td>
							<?php echo $this->Form->input('paterno', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Apellido Paterno', 'required' => true, 'label' => false)); ?>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>
							<?php echo $this->Form->input('email', array('class' => 'form-control', 'type' => 'email', 'placeholder' => 'Email', 'required' => true, 'label' => false, 'value' => (isset($usuario['email'])? $usuario['email'] : ''))); ?>
						</td>
					</tr>
					<tr class="cliente">
						<td>Telefono</td>
						<td>
							<?php echo $this->Form->input('telefono', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Telefono', 'required' => true, 'label' => false)); ?>
						</td>
					</tr>
					<tr class="cliente">
						<td>Dirección</td>
						<td>
							<?php echo $this->Form->input('direccion', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Dirección', 'required' => true, 'label' => false)); ?>
						</td>
					</tr>
					<tr class="cliente">
						<td>Región</td>
						<td>
							<?php echo $this->Form->input('id_region', array('class' => 'form-control', 'label' => false, 'options' => $regiones , 'empty' => 'Seleccionar Región', 'required' => true)); ?>
						</td>
					</tr>
					<tr class="cliente">
						<td>Provincia</td>
						<td>
							<?php echo $this->Form->input('id_provincia', array('class' => 'form-control', 'label' => false, 'options' => array() , 'empty' => 'Seleccionar Provincia', 'required' => true)); ?>
						</td>
					</tr>
					<tr class="cliente">
						<td>Comuna</td>
						<td>
							<?php echo $this->Form->input('id_comuna', array('class' => 'form-control','label' => false, 'options' => array() , 'empty' => 'Seleccionar Comuna', 'required' => true)); ?>
						</td>
					</tr>
					<tr>
						<td>Nombre de usuario</td>
						<td>
							<?php echo $this->Form->input('username', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nombre de usuario', 'required' => true, 'autofocus' => true, 'label' => false, 'value' => (isset($usuario['username'])? $usuario['username'] : ''))); ?>
						</td>
					</tr>
					<tr>
						<td>Contraseña</td>
						<td>
							<?php echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Contraseña', 'required' => true, 'label' => false, 'value' => (isset($usuario['password'])? $usuario['password'] : ''))); ?>
						</td>
					</tr>
					<tr>
						<td>Confirmar Contraseña</td>
						<td>
							<?php echo $this->Form->input('password2', array('class' => 'form-control', 'type' => 'password', 'placeholder' => 'Contraseña', 'required' => true, 'label' => false)); ?>
						</td>	
					</tr>
					<tr>
						<td colspan="2">
							<?php echo $this->Form->input('terminos', array( 'type' => 'checkbox', 'label' => array('text' => 'Acepto los' . $this->Html->link('Terminos y condiciones', Configure::read('App.staticUrl') . 'files/terminos_condiciones.pdf', array('target' => '_blank', 'class' => 'terminos'))), 'value' => 1, 'required' => true)); ?>
						</td>	
					</tr>
				</table>
				<?php
			echo $this->Form->end(array('label' => 'Enviar','class' => 'btn btn-primary pull-right')); 
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'home', 'action' => 'index')), array('class' => 'pull-right'));
		?>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">
$('#UserTipousuario').change(function(){
	if($(this).val() == 1){
		$('.persona').show();
		$('.cliente').hide();
		$('.cliente input, .cliente select').attr('disabled', true);
		$('.persona input, .persona select').attr('disabled', false);
	}else if($(this).val() == 2){
		$('.cliente').show();
		$('.persona').hide();
		$('.cliente input').attr('disabled', false);
		$('.persona input').attr('disabled', true);
	}
});
$('#UserIdRegion').change(function(){
	$.get( "/users/get_provincias/" + $(this).val() , function( data ) {
		$("#UserIdProvincia option").remove();
		$("#UserIdProvincia").append("<option value='0'>Seleccionar Provincia</option>");
		$.each(data, function(id, nombre){
			$("#UserIdProvincia").append("<option value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
$('#UserIdProvincia').change(function(){
	$.get( "/users/get_comunas/" + $(this).val() , function( data ) {
		$("#UserIdComuna option").remove();
		$("#UserIdComuna").append("<option value='0'>Seleccionar Comuna</option>");
		$.each(data, function(id, nombre){
			$("#UserIdComuna").append("<option value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
</script>
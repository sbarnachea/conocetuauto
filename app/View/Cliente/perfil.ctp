<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Mi Perfil');
?>
<div class="wrapper">
	<div class="contenido row">
		<div class="col-xs-12">
			<h3>Datos Personales</h3>
			<div class="row">
				<div class="col-xs-8">
					<div class="panel-gris">
						<div class="normal">
							<?php echo $this->Html->link('Editar', 'javascript:;', array('class' => 'btn btn-success pull-right edit')); ?>
							<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/'. (!empty($cliente['Cliente']['imagen'])? $cliente['Cliente']['imagen']: 'taller.jpg'), array('class' => 'pull-left')); ?>
							<table class="datos-personales pull-left">
								<tr>
									<td>Nombre</td>
									<td><?php echo $cliente['Cliente']['nombre']; ?></td>
								</tr>
								<tr>
									<td>Correo</td>
									<td><?php echo $cliente['Correo']['direccion']; ?></td>
								</tr>
								<tr>
									<td>Telefono</td>
									<td><?php echo $cliente['Cliente']['telefono']; ?></td>
								</tr>
								<tr>
									<td>Direccion</td>
									<td><?php echo $cliente['Cliente']['direccion']; ?></td>
								</tr>
								<tr>
									<td>Región</td>
									<td><?php echo $cliente['Region']['nombre']; ?></td>
								</tr>
								<tr>
									<td>Provincia</td>
									<td><?php echo $cliente['Provincia']['nombre']; ?></td>
								</tr>
								<tr>
									<td>Comuna</td>
									<td><?php echo $cliente['Comuna']['nombre']; ?></td>
								</tr>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="editar-datos">
							<?php echo $this->Html->link('Cancelar', 'javascript:;', array('class' => 'btn btn-danger pull-right cancelar')); ?>
							<?php echo $this->Form->create('Cliente', array(
								'url' => array('controller' => 'cliente', 'action' => 'perfil'),
								'type' => 'file'
							)); 
								echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $this->Session->read('Auth.User.Cliente.id')));
							?>
							<table class="datos-personales">
								<tr>
									<td>Nombre</td>
									<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $cliente['Cliente']['nombre'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Correo</td>
									<td><?php 
									echo $this->Form->input('Correo.id', array( 'type' => 'hidden', 'value' => $cliente['Correo']['id']));
									echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'email', 'required' => true, 'label' => false, 'value' => $cliente['Correo']['direccion'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Telefono</td>
									<td><?php echo $this->Form->input('telefono', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $cliente['Cliente']['telefono'])); ?></td>
								</tr>
								<tr>
									<td>Direccion</td>
									<td><?php echo $this->Form->input('direccion', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $cliente['Cliente']['direccion'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Región</td>
									<td><?php echo $this->Form->input('id_region', array('class' => 'form-control','options' => $regiones, 'required' => true, 'label' => false, 'disabled' => true, 'default' => $cliente['Cliente']['id_region'])); ?></td>
								</tr>
								<tr>
									<td>Provincia</td>
									<td>
										<?php echo $this->Form->input('id_provincia', array('class' => 'form-control','required' => true, 'label' => false, 'options' => array() , 'empty' => 'Seleccionar Provincia')); ?>
									</td>
								</tr>
								<tr>
									<td>Comuna</td>
									<td>
										<?php echo $this->Form->input('id_comuna', array('class' => 'form-control','required' => true, 'label' => false, 'options' => array() , 'empty' => 'Seleccionar Comuna')); ?>
									</td>
								</tr>
								<tr>
									<td>Foto</td>
									<td>
										<?php echo $this->Form->input('imagen', array('required' => true, 'label' => false, 'type' => 'file')); ?>
									</td>
								</tr>
							</table>
							<?php echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); ?>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="panel-gris">
						<h4>Cambiar contraseña</h4>
						<?php echo $this->Form->create('User', array(
							'url' => array('controller' => 'cliente', 'action' => 'perfil'),
							'type' => 'post'
						)); 
							echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
						?>
						<table class="datos-personales">
							<tr>
								<td><?php echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password', 'required' => true, 'label' => false, 'placeholder' => 'Contraseña nueva')); ?></td>
							</tr>
							<tr>
								<td><?php echo $this->Form->input('password2', array('class' => 'form-control', 'type' => 'password', 'required' => true, 'label' => false, 'placeholder' => 'Repetir contraseña')); ?></td>
							</tr>
						</table>
						<?php echo $this->Form->end(array('label' => 'Cambiar','class' => 'btn btn-primary pull-right')); ?>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.edit').click(function(){
		$('.editar-datos').show();
		$('.editar-datos input, select').attr('disabled', false);
		$('.normal').hide();
	});
	$('.cancelar').click(function(){
		$('.normal').show();
		$('.editar-datos input, select').attr('disabled', true);
		$('.editar-datos').hide();
	});

	$('#ClienteIdRegion').change(function(){
		$.get( "/users/get_provincias/" + $(this).val() , function( data ) {
			$("#ClienteIdProvincia option").remove();
			$("#ClienteIdProvincia").append("<option value='0'>Seleccionar Provincia</option>");
			$.each(data, function(id, nombre){
				var selected = '';
				if(id == <?php echo $cliente['Cliente']['id_provincia']; ?>){
					selected = 'selected';
				}
				$("#ClienteIdProvincia").append("<option " + selected +" value=\""+id+"\">"+nombre+"</option>");
			});
			$('#ClienteIdProvincia').change();
		}, "json" );
	}).change();

	$('#ClienteIdProvincia').change(function(){
		$.get( "/users/get_comunas/" + $(this).val() , function( data ) {
			$("#ClienteIdComuna option").remove();
			$("#ClienteIdComuna").append("<option value='0'>Seleccionar Comuna</option>");
			$.each(data, function(id, nombre){
				var selecteds = '';
				if(id == <?php echo $cliente['Cliente']['id_comuna']; ?>){
					selecteds = 'selected';
				}
				$("#ClienteIdComuna").append("<option " + selecteds +" value=\""+id+"\">"+nombre+"</option>");
			});
		}, "json" );
	});
</script>
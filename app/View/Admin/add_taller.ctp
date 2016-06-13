<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres',  array('controller' => 'admin', 'action' => 'talleres'));
	$this->Html->addCrumb('Agregar Taller');
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'talleres')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Agregar Taller</h3>
		<?php 
			echo $this->Form->create('Cliente', array(
				'url' => array('controller' => 'admin', 'action' => 'add_taller'),
				'type' => 'file',
				'class' => 'pull-left formulario',
				'autocomplete' => 'off'
			)); 
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'email', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Telefono</td>
					<td><?php echo $this->Form->input('telefono', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Dirección</td>
					<td><?php echo $this->Form->input('direccion', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Región</td>
					<td>
						<?php echo $this->Form->input('id_region', array('class' => 'form-control','required' => true, 'label' => false, 'options' => $regiones , 'empty' => 'Seleccionar Región')); ?>
					</td>
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
					<td><?php echo $this->Form->input('imagen', array( 'type' => 'file', 'required' => true, 'label' => false));
						echo $this->Form->input('dir', array( 'type' => 'hidden')); ?></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><?php echo $this->Form->input('User.username', array('class' => 'form-control', 'required' => true, 'type' => 'text', 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Contraseña </td>
					<td><?php echo $this->Form->input('User.password', array('class' => 'form-control', 'required' => true, 'type' => 'password', 'label' => false)); ?><small>(se le solicitará cambiar la contraseña al usuario)</small></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Crear','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">
$('#ClienteIdRegion').change(function(){
	$.get( "/users/get_provincias/" + $(this).val() , function( data ) {
		$("#ClienteIdProvincia option").remove();
		$("#ClienteIdProvincia").append("<option value='0'>Seleccionar Provincia</option>");
		$.each(data, function(id, nombre){
			$("#ClienteIdProvincia").append("<option value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
$('#ClienteIdProvincia').change(function(){
	$.get( "/users/get_comunas/" + $(this).val() , function( data ) {
		$("#ClienteIdComuna option").remove();
		$("#ClienteIdComuna").append("<option value='0'>Seleccionar Comuna</option>");
		$.each(data, function(id, nombre){
			$("#ClienteIdComuna").append("<option value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
</script>
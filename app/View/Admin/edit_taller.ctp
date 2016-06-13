<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres',  array('controller' => 'admin', 'action' => 'talleres'));
	$this->Html->addCrumb('Editar ' . ucwords($taller['Cliente']['nombre']));
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'talleres')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Editar Taller</h3>
		<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/' . $taller['Cliente']['imagen'], array('class' => array('pull-left'))); ?>
		<?php 
			echo $this->Form->create('Cliente', array(
				'url' => array('controller' => 'admin', 'action' => 'edit_taller', $taller['Cliente']['id']),
				'type' => 'file',
				'class' => 'pull-left formulario'
			)); 
				echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $taller['Cliente']['id']));
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $taller['Cliente']['nombre'])); ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $taller['Correo']['direccion'])); ?></td>
				</tr>
				<tr>
					<td>Telefono</td>
					<td><?php echo $this->Form->input('telefono', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $taller['Cliente']['telefono'])); ?></td>
				</tr>
				<tr>
					<td>Dirección</td>
					<td><?php echo $this->Form->input('direccion', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $taller['Cliente']['direccion'])); ?></td>
				</tr>
				<tr>
					<td>Región</td>
					<td>
						<?php echo $this->Form->input('id_region', array('class' => 'form-control','required' => true, 'label' => false, 'options' => $regiones , 'empty' => 'Seleccionar Región', 'default' => $taller['Cliente']['id_region'])); ?>
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
					<td><?php echo $this->Form->input('imagen', array( 'type' => 'file', 'label' => false));
						echo $this->Form->input('dir', array( 'type' => 'hidden')); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Editar','class' => 'btn btn-primary pull-right')); 
			
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
			var selected = '';
			if(id == <?php echo $taller['Cliente']['id_provincia']; ?>){
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
			if(id == <?php echo $taller['Cliente']['id_comuna']; ?>){
				selecteds = 'selected';
			}
			$("#ClienteIdComuna").append("<option " + selecteds +" value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
</script>
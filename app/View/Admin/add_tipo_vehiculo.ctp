<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Tipos Vehiculos',  array('controller' => 'admin', 'action' => 'tipo_vehiculos'));
	$this->Html->addCrumb('Agregar Tipo Vehiculo');
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'tipo_vehiculos')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Agregar Tipo Vehiculo</h3>
		<?php 
			echo $this->Form->create('TipoVehiculo', array(
				'url' => array('controller' => 'admin', 'action' => 'add_tipo_vehiculo'),
				'class' => 'pull-left formulario'
			)); 
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'tipo_vehiculos')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
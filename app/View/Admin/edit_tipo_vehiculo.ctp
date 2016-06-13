<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Tipos Vehiculos',  array('controller' => 'admin', 'action' => 'tipo_vehiculo'));
	$this->Html->addCrumb('Editar ' . ucwords($tipoVehiculo['TipoVehiculo']['nombre']));
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'tipo_vehiculos')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Editar Tipo Vehiculo</h3>
		<?php 
			echo $this->Form->create('TipoVehiculo', array(
				'url' => array('controller' => 'admin', 'action' => 'edit_tipo_vehiculo', $tipoVehiculo['TipoVehiculo']['id']),
				'class' => 'pull-left formulario'
			)); 
				echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $tipoVehiculo['TipoVehiculo']['id']));
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $tipoVehiculo['TipoVehiculo']['nombre'])); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'tipo_vehiculos')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Editar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
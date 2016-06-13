<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Administrador',  array('controller' => 'admin', 'action' => 'index'));
	$this->Html->addCrumb('Modelos de ' . ucwords($marca['Marca']['nombre']),  array('controller' => 'admin', 'action' => 'list_modelo', $marca['Marca']['id']));
	$this->Html->addCrumb('Agregar Modelo');
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'list_modelo', $marca['Marca']['id'])), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Agregar Modelo</h3>
		<?php 
			echo $this->Form->create('Modelo', array(
				'url' => array('controller' => 'admin', 'action' => 'add_modelo', $marca['Marca']['id']),
				'type' => 'file',
				'class' => 'pull-left formulario'
			)); 
			echo $this->Form->input('id_marca', array('type' => 'hidden', 'value' => $marca['Marca']['id']));
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Tipo Vehiculo</td>
					<td><?php echo $this->Form->input('id_tipo_vehiculo', array('class' => 'form-control', 'options' => $tiposVehiculos, 'required' => true, 'label' => false, 'empty' => 'Seleccionar')); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'index')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
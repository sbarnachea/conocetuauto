<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Administrador',  array('controller' => 'admin', 'action' => 'index'));
	$this->Html->addCrumb('Modelos de ' . ucwords($modelo['Marca']['nombre']),  array('controller' => 'admin', 'action' => 'list_modelo', $modelo['Marca']['id']));
	$this->Html->addCrumb('Editar Modelo ' . ucwords($modelo['Modelo']['nombre']));
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'list_modelo', $modelo['Marca']['id'])), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Editar Modelo</h3>
		<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/logos/' . $modelo['Marca']['imagen'], array('class' => array('pull-left'))); ?>
		<?php 
			echo $this->Form->create('Modelo', array(
				'url' => array('controller' => 'admin', 'action' => 'edit_modelo', $modelo['Marca']['id'], $modelo['Modelo']['id']),
				'class' => 'pull-left formulario'
			)); 
				echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $modelo['Modelo']['id']));
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $modelo['Modelo']['nombre'])); ?></td>
				</tr>
				<tr>
					<td>Tipo de Vehiculo</td>
					<td><?php echo $this->Form->input('id_tipo_vehiculo', array('class' => 'form-control', 'options' => $tiposVehiculos, 'required' => true, 'label' => false, 'empty' => 'Seleccionar', 'default' => $modelo['Modelo']['id_tipo_vehiculo'])); ?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'list_modelo', $modelo['Marca']['id'])), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Editar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Administrador',  array('controller' => 'admin', 'action' => 'index'));
	$this->Html->addCrumb('Agregar Marca');
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'index')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Agregar Marca</h3>
		<?php 
			echo $this->Form->create('Marca', array(
				'url' => array('controller' => 'admin', 'action' => 'add_marca'),
				'type' => 'file',
				'class' => 'pull-left formulario'
			)); 
			?>
			<table class="table-edit">
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Portada</td>
					<td><?php echo $this->Form->input('portada', array( 'type' => 'checkbox', 'label' => false, 'value' => 1)); ?></td>
				</tr>
				<tr>
					<td>Imagen</td>
					<td><?php echo $this->Form->input('imagen', array( 'type' => 'file', 'label' => false));
						echo $this->Form->input('dir', array( 'type' => 'hidden')); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'index')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
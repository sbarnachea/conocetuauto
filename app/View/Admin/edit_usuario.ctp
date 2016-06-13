<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Usuarios',  array('controller' => 'admin', 'action' => 'usuarios'));
	$this->Html->addCrumb('Editar ' . ucwords($usuario['Persona']['nombre']));
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'usuarios')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Editar Usuario</h3>
		<?php 
			echo $this->Form->create('Persona', array(
				'url' => array('controller' => 'admin', 'action' => 'edit_usuario', $usuario['Persona']['id']),
				'class' => 'pull-left formulario'
			)); 
				echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $usuario['Persona']['id']));
			?>
			<table class="table-edit">
				<tr>
					<td>Tipo de Usuario</td>
					<td>
						<?php echo $this->Form->input('User.id_tipo_usuario', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false, 'options' => array(1 => 'Normal', 3 => 'Administrador'), 'empty' => 'Seleccionar', 'default' => $usuario['User']['id_tipo_usuario'])); ?>
					</td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $usuario['Persona']['nombre'])); ?></td>
				</tr>
				<tr>
					<td>Apellido Paterno</td>
					<td><?php echo $this->Form->input('paterno', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $usuario['Persona']['paterno'])); ?></td>
				</tr>
				<tr>
					<td>Apellido Materno</td>
					<td><?php echo $this->Form->input('materno', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $usuario['Persona']['materno'])); ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $usuario['Correo']['direccion'])); ?></td>
				</tr>
				<tr>
					<td>Sexo</td>
					<td><?php echo $this->Form->input('Persona.sexo', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false, 'options' => array(1 => 'Masculino', 2 => 'Femenino'), 'empty' => 'Seleccionar', 'default' => $usuario['Persona']['sexo'])); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Editar','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
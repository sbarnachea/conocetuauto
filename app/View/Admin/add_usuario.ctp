<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Usuarios',  array('controller' => 'admin', 'action' => 'usuarios'));
	$this->Html->addCrumb('Agregar Usuario ');
?>
<div class="wrapper editar">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'usuarios')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Agregar Taller</h3>
		<?php 
			echo $this->Form->create('Persona', array(
				'url' => array('controller' => 'admin', 'action' => 'add_usuario'),
				'class' => 'pull-left formulario',
				'autocomplete' => 'off'
			)); 
			?>
			<table class="table-edit">
				<tr>
					<td>Tipo de Usuario</td>
					<td>
						<?php echo $this->Form->input('User.id_tipo_usuario', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false, 'options' => array(1 => 'Normal', 3 => 'Administrador'), 'empty' => 'Seleccionar')); ?>
					</td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Apellido Paterno</td>
					<td><?php echo $this->Form->input('paterno', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Apellido Materno</td>
					<td><?php echo $this->Form->input('materno', array('class' => 'form-control', 'type' => 'text', 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Sexo</td>
					<td><?php echo $this->Form->input('Persona.sexo', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario', 'required' => true, 'label' => false, 'options' => array(1 => 'Masculino', 2 => 'Femenino'), 'empty' => 'Seleccionar')); ?></td>
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
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios')), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Crear','class' => 'btn btn-primary pull-right')); 
			
		?>
		<div class="clearfix"></div>
	</div>
</div>
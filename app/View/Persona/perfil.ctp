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
							<table class="datos-personales">
								<tr>
									<td>Nombre</td>
									<td><?php echo $persona['Persona']['nombre'] . ' ' . $persona['Persona']['paterno'] . ' ' . $persona['Persona']['materno']; ?></td>
								</tr>
								<tr>
									<td>Correo</td>
									<td><?php echo $persona['Correo']['direccion']; ?></td>
								</tr>
								<tr>
									<td>Sexo</td>
									<td><?php echo ($persona['Persona']['sexo'] == 1? 'Masculino': ($persona['Persona']['sexo'] == 2? 'Femenino': '')); ?></td>
								</tr>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="editar-datos">
							<?php echo $this->Html->link('Cancelar', 'javascript:;', array('class' => 'btn btn-danger pull-right cancelar')); ?>
							<?php echo $this->Form->create('Persona', array(
								'url' => array('controller' => 'persona', 'action' => 'perfil'),
								'type' => 'post'
							)); 
								echo $this->Form->input('id', array( 'type' => 'hidden', 'value' => $this->Session->read('Auth.User.Persona.id')));
							?>
							<table class="datos-personales">
								<tr>
									<td>Nombre</td>
									<td><?php echo $this->Form->input('nombre', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $persona['Persona']['nombre'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Apellido Paterno</td>
									<td><?php echo $this->Form->input('paterno', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $persona['Persona']['paterno'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Apellido Materno</td>
									<td><?php echo $this->Form->input('materno', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $persona['Persona']['materno'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Correo</td>
									<td><?php 
									echo $this->Form->input('Correo.id', array( 'type' => 'hidden', 'value' => $persona['Correo']['id']));
									echo $this->Form->input('Correo.direccion', array('class' => 'form-control', 'type' => 'email', 'required' => true, 'label' => false, 'value' => $persona['Correo']['direccion'], 'disabled' => true)); ?></td>
								</tr>
								<tr>
									<td>Sexo</td>
									<td><?php echo $this->Form->input('sexo', array('class' => 'form-control','options' => array(1 => 'Masculino', 2 => 'Femenino'), 'required' => true, 'label' => false, 'value' => $persona['Persona']['nombre'], 'disabled' => true, 'default' => $persona['Persona']['sexo'])); ?></td>
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
							'url' => array('controller' => 'persona', 'action' => 'perfil'),
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
				<div class="clearfix"></div>
				<div class="col-xs-12 comentarios ">
					<h3>Tus comentarios</h3>
					<div class="row">
						<div class="col-xs-8 coment">
							<?php foreach($fallas as $falla){ ?>
							<a href="<?php echo $this->Html->url(array('controller' => 'falla', 'action' => 'detalle', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id'], $falla['Falla']['id'])); ?>" class="item">
								<div class="panel-gris row">
									<div class="info pull-left col-xs-2">
										<h5><?php echo ucfirst($falla['Vehiculo']['Marca']['nombre']) . ' ' . ucwords($falla['Vehiculo']['Modelo']['nombre']); ?></h5>
										<p><?php echo  date('d-m-Y H:i', strtotime($falla['Falla']['created']));?></p>
									</div>
									<div class="descripcion pull-left col-xs-10">
										<span><?php echo ucfirst($falla['TipoFalla']['nombre']); ?></span>
										<h5><?php echo ucfirst($falla['Falla']['titulo']); ?></h5>
										<p><?php echo nl2br(ucfirst($falla['Falla']['descripcion'])); ?></p>
									</div>
									<div class="clearfix"></div>
									<div class="numero-comentarios pull-right">
										<?php echo $falla['Falla']['numero'] . ($falla['Falla']['numero'] == 1? ' Comentario': ' Comentarios'); ?>
									</div>
									<div class="pull-right">
										Comentar
									</div>
									<?php 
									$icono = $clase = '';
									if($falla['Falla']['tipo_comentario'] == 1){
										$icono = 'down';
										$clase = 'danger';
									}else{
										$icono = 'up';
										$clase = 'success';
									} ?>
									<span class="pull-right tipo-comentario label label-<?php echo $clase; ?>">
										<i class="fa fa-thumbs-o-<?php echo $icono; ?>"></i>
									</span>
								</div>
							</a>
							<?php } ?>
						</div>
						<div class="clearfix"></div>
						<div class="col-xs-8">
							<?php if(count($fallas) == 4) 
								echo $this->Html->link('Ver más', 'javascript:;', array('class' => 'ver-mas btn btn-primary')); ?>
						</div>
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
	var page = 1;
	$('.ver-mas').click(function(){
		page++;
		$.get( "/persona/get_comentarios/" + page , function( data ) {
			if($(data).find('a.item').length < 4){
				$('.ver-mas').hide();
			}
			$(data).appendTo('.comentarios .coment');
			return false;
		});
	});
</script>
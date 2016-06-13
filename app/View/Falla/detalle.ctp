<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas', array('controller' => 'marca', 'action' => 'index'));

	$this->Html->addCrumb('Modelos ' . ucwords($falla['Vehiculo']['Marca']['nombre']), array('controller' => 'modelo', 'action' => 'index', $falla['Vehiculo']['Marca']['id']));
	$this->Html->addCrumb('Detalle ' . ucwords($falla['Vehiculo']['Marca']['nombre'] . ' ' . $falla['Vehiculo']['Modelo']['nombre']), array('controller' => 'modelo', 'action' => 'detalle', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id']));
	$this->Html->addCrumb('Listado Fallas ' . ucwords($falla['Vehiculo']['Marca']['nombre'] . ' ' . $falla['Vehiculo']['Modelo']['nombre']), array('controller' => 'falla', 'action' => 'listado', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id']));
	$this->Html->addCrumb('Detalle Falla ' . ucwords($falla['Falla']['titulo']));
	?>
<div class="wrapper">
	<div class="contenido comentar">
		<div class="row">
			<div class="col-xs-8">
				<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'falla', 'action' => 'listado', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id'])), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
				<h3><?php echo ucfirst($falla['Falla']['titulo']); ?></h3> 
				<span class="categoria"><?php echo ucfirst($falla['TipoFalla']['nombre']); ?></span>
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
				<div class="panel-gris row">
					<div class="info pull-left col-xs-2">
						<h5><?php echo  (isset($falla['User']['Persona'][0]['nombre'])? $falla['User']['Persona'][0]['nombre']: $falla['Falla']['nick']); ?></h5>
						<p><?php echo  date('d-m-Y H:i', strtotime($falla['Falla']['created']));?></p>
					</div>
					<div class="descripcion pull-left col-xs-10">
						<p><?php echo nl2br(ucfirst($falla['Falla']['descripcion'])); ?></p>
					</div>
					<div class="pull-right">
						<?php echo $this->Html->link('Denunciar', $this->Html->url(array('controller' => 'falla', 'action' => 'denunciar', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id'], $falla['Falla']['id'])));?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-gris row">
				<?php 
				if($this->Session->check('Auth.User')){
					echo $this->Form->create('ComentarioFalla', array(
						'url' => array('controller' => 'falla', 'action' => 'add_comentario', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id'], $falla['Falla']['id']),
						'class' => 'pull-left formulario-comentar'
					)); ?>
						<div class="col-xs-10">
							<?php echo $this->Form->input('descripcion', array('class' => 'form-control', 'type' => 'textarea', 'required' => true, 'label' => false, 'rows' => 1));?>
						</div>
					<?php echo $this->Form->end(array('label' => 'Comentar','class' => 'btn btn-primary pull-right')); 
				}else{ ?>
					<div class="alert alert-danger">
						<p>Debes <?php echo $this->Html->link('Ingresar', $this->Html->url(array('controller' => 'login')));?> para poder comentar, si no tienes cuenta <?php echo $this->Html->link('Regístrate', $this->Html->url(array('controller' => 'registro'))); ?>. </p>
					</div>
				<?php } ?>
				</div>
				<div class="row comentarios">
				<?php foreach($comentarios as $comentario){ ?>
					<div class="col-xs-11 col-xs-offset-1">
						<?php if($comentario['User']['id_tipo_usuario'] == 2) { ?>
							<a href="<?php echo $this->Html->url(array('controller' => 'cliente', 'action' => 'detalle', $comentario['User']['Cliente'][0]['id'])); ?>">
						<?php } ?>
						<div class="panel-gris row">
							<div class="info pull-left col-xs-2">
								<h5><?php echo ($comentario['User']['id_tipo_usuario'] == 2 ? $comentario['User']['Cliente'][0]['nombre']: $comentario['User']['Persona'][0]['nombre']); ?></h5>
								<p><?php echo  date('d-m-Y H:i', strtotime($comentario['ComentarioFalla']['created']));?></p>
							</div>
							<div class="descripcion pull-left col-xs-10">
								<p><?php echo nl2br(ucfirst($comentario['ComentarioFalla']['descripcion'])); ?></p>
							</div>
							<?php if($comentario['User']['id_tipo_usuario'] == 2) { ?>
								<div class="pull-right ver-taller">Detalle taller <?php echo ($this->Session->read('Auth.User.id_tipo_usuario') != 2 ? '| Votar por taller' : ''); ?></div>
							<?php } ?>
							<div class="clearfix"></div>
						</div>
						<?php if($comentario['User']['id_tipo_usuario'] == 2) { ?>
							</a>
						<?php } ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="col-xs-4">
				<?php echo $this->element('anuncio'); ?>
			</div>
		</div>
	</div>
</div>
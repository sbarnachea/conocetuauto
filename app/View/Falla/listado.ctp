<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas', array('controller' => 'marca', 'action' => 'index'));
	$this->Html->addCrumb('Modelos ' . ucwords($marca['Marca']['nombre']), array('controller' => 'modelo', 'action' => 'index', $marca['Marca']['id']));
	$this->Html->addCrumb('Detalle ' . ucwords($marca['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']), array('controller' => 'modelo', 'action' => 'detalle', $marca['Marca']['id'], $modelo['Modelo']['id']));
	$this->Html->addCrumb('Listado Fallas ' . ucwords($marca['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']));
	?>
<div class="wrapper">
	<div class="contenido">
		<div class="row">
			<div class="comentarios col-xs-8">
				<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'modelo', 'action' => 'detalle', $marca['Marca']['id'], $modelo['Modelo']['id'])), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
				<div class="clearfix"></div>
				<h3 class="pull-left">Listado Fallas <?php echo ucwords($marca['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']); ?></h3> 
				<div class="clearfix"></div>
				<?php 
				foreach($fallas as $falla){ ?>
					<a href="<?php echo $this->Html->url(array('controller' => 'falla', 'action' => 'detalle',$marca['Marca']['id'], $modelo['Modelo']['id'], $falla['Falla']['id'])); ?>">
						<div class="panel-gris row">
							<div class="info pull-left col-xs-2">
								<h5><?php echo  (isset($falla['User']['Persona'][0]['nombre'])? $falla['User']['Persona'][0]['nombre']: $falla['Falla']['nick']); ?></h5>
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
							<div class="accion pull-right">
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
				<?php } 
				echo $this->element('paginador');
				?>
			</div>
			<div class="col-xs-4">
				<?php echo $this->element('anuncio'); ?>
			</div>
		</div>
	</div>
</div>
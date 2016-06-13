<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas', array('controller' => 'marca', 'action' => 'index'));
	$this->Html->addCrumb('Modelos ' . ucwords($marca['Marca']['nombre']));
?>
<div class="wrapper">
	<div class="contenido">
		<div class="modelo-falla row">
			<div class="col-xs-6">
				<div class="fallas pull-left">
					<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'marca', 'action' => 'index')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
					<h3>Modelos con mas comentarios de <?php echo ucwords($marca['Marca']['nombre']); ?></h3>
					<?php 
					if(!empty($masfallados)){
						$max = $masfallados[0]['numero'];
						foreach($masfallados as $modelo){?>
							<div class="item">
								<?php echo $this->Html->link(ucwords($modelo['nombre']),$this->Html->url(array('controller' => 'modelo', 'action' => 'detalle', $modelo['id_marca'], $modelo['id_modelo'])), array('escape' => false, 'class' => 'pull-left')); ?>
								<div class="content-bar pull-left">
									<div class="bar" style="width:<?php echo ($modelo['numero']*100)/$max; ?>%"><?php echo $modelo['numero']; ?></div>
								</div>
								<div class="clearfix"></div>
							</div>
					<?php }
					}else{ ?>
						<p>No hay fallas registradas para la marca <?php echo ucwords($marca['Marca']['nombre']); ?></p>
					<?php } ?>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="nueva-falla pull-left">
					<h4>¿Tu auto falla?</h4>
					<p>Comparte tu problema o experiencia con nosotros</p>
					<?php echo $this->Html->link('<i class="fa fa-plus"></i> Comparte tu opinión', $this->Html->url(array('controller' => 'falla', 'action' => 'elegir_modelo', $marca['Marca']['id'])), array('class' => array('btn btn-success'), 'escape' => false)); ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
		<h3>Selecciona el modelo de <?php echo ucwords($marca['Marca']['nombre']); ?></h3>
		<div class="modelos row">
			<div class="col-xs-3">
				<div class="marca pull-left">
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/marca/resize/' . $marca['Marca']['imagen']); ?>
				</div>
			</div>
			<div class="col-xs-9">
				<div class="listado pull-left panel-gris">
					<?php foreach ($modelos as $modelo) { ?>
						<div class="item pull-left">
							<?php echo $this->Html->link(ucwords($modelo['Modelo']['nombre']),$this->Html->url(array('controller' => 'modelo', 'action' => 'detalle', $marca['Marca']['id'], $modelo['Modelo']['id'])), array('escape' => false)); ?>
						</div>	
					<?php } ?>
					<div class="clearfix"></div>
				</div>

			<div class="clearfix"></div>
		</div>
	</div>
</div>

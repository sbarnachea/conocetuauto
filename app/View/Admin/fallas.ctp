<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas');
?>
<div class="wrapper administrador">
	<div class="contenido">
		<ul class="nav nav-tabs" role="tablist">
			<li>
				<?php echo $this->Html->link('Marcas',$this->Html->url(array('controller' => 'admin', 'action' => 'index'))); ?>
			</li>
			<li>
				<?php echo $this->Html->link('Tipos Vehiculos',$this->Html->url(array('controller' => 'admin', 'action' => 'tipo_vehiculos'))); ?>
			</li>
			<li>
				<?php echo $this->Html->link('Tipos Fallas',$this->Html->url(array('controller' => 'admin', 'action' => 'tipo_fallas'))); ?>
			</li>
			<li class="active">
				<?php echo $this->Html->link('Fallas',$this->Html->url(array('controller' => 'admin', 'action' => 'fallas'))); ?>
			</li>
			<li>
				<?php echo $this->Html->link('Anuncios',$this->Html->url(array('controller' => 'admin', 'action' => 'anuncios'))); ?>
			</li>
			<li>
				<?php echo $this->Html->link('Talleres',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres'))); ?>
			</li>
			<li>
	 			<?php echo $this->Html->link('Usuarios',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios'))); ?>
			</li>
		</ul>
		<div class="pull-left herramientas">
			<h3>Total Fallas</h3>
			<?php 
				echo $this->Form->create('Marca', array(
					'url' => array('controller' => 'admin', 'action' => 'fallas'),
					'class' => array('search-form pull-right'),
					'type' => 'post'
				)); 
			?>
				<input type="text" placeholder="Buscador" name="id" class="search-text"/>
				<input type="submit" class="search-submit" value=""/><br style="clear:both;"/>
			<?php 
				echo $this->Form->end();
			?>
			<div class="row">
				<div class="col-xs-6">Total</div>
				<div class="col-xs-6"><?php echo $fallasTotal[0][0]['total']; ?></div>
				<div class="col-xs-6">Positivas</div>
				<div class="col-xs-6"><?php echo $fallasPositiva[0][0]['total']; ?></div>
				<div class="col-xs-6">Negativas</div>
				<div class="col-xs-6"><?php echo $fallasNegativa[0][0]['total']; ?></div>
				<div class="col-xs-6">Encuesta</div>
				<div class="col-xs-6"><?php echo $fallasEncuesta[0][0]['total']; ?></div>
			</div>
		</div>
		<div class="content pull-left">
			<?php if(isset($fallasBusqueda)){ ?>
				<p class="resultado-busqueda">
					Resultados de busqueda de <span>" <?php echo $id; ?> "</span>, haga click <?php echo $this->Html->link('aquí',$this->Html->url(array('controller' => 'admin', 'action' => 'fallas'))); ?> para mosrar todo
				</p>
			<?php } ?>
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Tipo Falla</th>
						<th>Título</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$fallas = (isset($fallasBusqueda) ? $fallasBusqueda: $fallasPaginator);
					if(!empty($fallas)){
						foreach($fallas as $falla){ ?>
							<tr>
								<td width="5%"><?php echo $falla['Falla']['id']; ?></td>
								<td width="20%"><?php echo ucwords($falla['Vehiculo']['Marca']['nombre']); ?></td>
								<td width="20%"><?php echo ucwords($falla['Vehiculo']['Modelo']['nombre']); ?></td>
								<td width="20%"><?php echo ucwords($falla['TipoFalla']['nombre']); ?></td>
								<td width="20%"><?php echo ucfirst($falla['Falla']['titulo']); ?></td>
								<td width="15%">
									<?php 
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_falla', $falla['Falla']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
									echo $this->Html->link('<i class="fa fa-eye"></i>', $this->Html->url(array('controller' => 'falla', 'action' => 'detalle', $falla['Vehiculo']['Marca']['id'], $falla['Vehiculo']['Modelo']['id'], $falla['Falla']['id'])), array('escape' => false, 'title' => 'Ver', 'class' => array('btn btn-primary'), 'target' => '_blank'));
									?>
								</td>
							</tr><?php 
						} 
					}else{ ?>
						<tr>
							<td colspan="5">
								<p>No hay registros</p>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<div class="clearfix"></div>
			<?php
			if(isset($fallasPaginator)){
				echo $this->element('paginador');
			} ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Anuncios');
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
			<li>
				<?php echo $this->Html->link('Fallas',$this->Html->url(array('controller' => 'admin', 'action' => 'fallas'))); ?>
			</li>
			<li class="active">
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
			<h3>Total Anuncios</h3>
			<?php 
				echo $this->Form->create('Marca', array(
					'url' => array('controller' => 'admin', 'action' => 'anuncios'),
					'class' => array('search-form pull-right'),
					'type' => 'post'
				)); 
			?>
				<input type="text" placeholder="Buscador" name="nombre" class="search-text"/>
				<input type="submit" class="search-submit" value=""/><br style="clear:both;"/>
			<?php 
				echo $this->Form->end();
			?>
			<div class="row">
				<div class="col-xs-6">Total</div>
				<div class="col-xs-6"><?php echo $total[0][0]['total']; ?></div>
				<div class="col-xs-6">Espera Pago</div>
				<div class="col-xs-6"><?php echo $espera[0][0]['total']; ?></div>
				<div class="col-xs-6">Aprobado</div>
				<div class="col-xs-6"><?php echo $aprobado[0][0]['total']; ?></div>
				<div class="col-xs-6">Finalizado</div>
				<div class="col-xs-6"><?php echo $finalizado[0][0]['total']; ?></div>
			</div>
		</div>
		<div class="content pull-left">
			<?php if(isset($anunciosBusqueda)){ ?>
				<p class="resultado-busqueda">
					Resultados de busqueda de <span>" <?php echo $nombre; ?> "</span>, haga click <?php echo $this->Html->link('aquí',$this->Html->url(array('controller' => 'admin', 'action' => 'anuncios'))); ?> para mosrar todo
				</p>
			<?php } ?>
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Titulo</th>
						<th>Estado</th>
						<th>Fecha Termino</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$anuncios = (isset($anunciosBusqueda) ? $anunciosBusqueda: $anunciosPaginator);
					if(!empty($anuncios)){
						foreach($anuncios as $anuncio){ ?>
							<tr>
								<td width="5%"><?php echo $anuncio['Anuncio']['id']; ?></td>
								<td width="35%"><?php echo ucwords($anuncio['Anuncio']['titulo']); ?></td>
								<td width="25%"><?php echo ($anuncio['Anuncio']['estado'] == 0? 'Espera de Pago': ($anuncio['Anuncio']['estado'] == 1? 'Aprobado': ($anuncio['Anuncio']['estado'] == 2? 'Finalizado': ''))); ?></td>
								<td width="20%"><?php 
									if($anuncio['Anuncio']['estado'] == 1){
										$nuevafecha = strtotime ( '+30 day' , strtotime ( $anuncio['Anuncio']['fecha_inicio'] ) ) ;
										$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
										echo $nuevafecha; 
									}?>
								</td>
								<td width="15%">
									<?php 
									if($anuncio['Anuncio']['estado'] == 0){
										echo $this->Html->link('<i class="fa fa-check"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'aprobar_anuncio', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Aprobar Anuncio', 'class' => array('btn btn-success')));
									}
									if($anuncio['Anuncio']['estado'] != 2){
										echo $this->Html->link('<i class="fa fa-times-circle"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'finalizar_anuncio', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Finalizar', 'class' => array('btn btn-danger')));
									}
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_anuncio', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
									if($anuncio['Anuncio']['estado'] == 1){
										echo $this->Html->link('<i class="fa fa-eye"></i>', $this->Html->url(array('controller' => 'anuncio', 'action' => 'detalle', $anuncio['Anuncio']['id_cliente'], $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Ver', 'class' => array('btn btn-primary'), 'target' => '_blank'));
									}
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
			if(isset($marcasPaginator)){
				echo $this->element('paginador');
			} ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
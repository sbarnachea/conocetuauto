<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres');
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
			<li>
				<?php echo $this->Html->link('Anuncios',$this->Html->url(array('controller' => 'admin', 'action' => 'anuncios'))); ?>
			</li>
			<li class="active">
				<?php echo $this->Html->link('Talleres',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres'))); ?>
			</li>
			<li>
	 			<?php echo $this->Html->link('Usuarios',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios'))); ?>
			</li>
		</ul>
		<div class="pull-left herramientas">
			<h3><i class="fa fa-gear"></i> Opciones Avanzadas</h3>
			<?php 
				echo $this->Form->create('Cliente', array(
					'url' => array('controller' => 'admin', 'action' => 'talleres'),
					'class' => array('search-form pull-right'),
					'type' => 'post'
				)); 
			?>
				<input type="text" placeholder="Buscador" name="nombre" class="search-text"/>
				<input type="submit" class="search-submit" value=""/><br style="clear:both;"/>
			<?php 
				echo $this->Form->end();

			?>
			<div class="agregar">
				<?php
					echo $this->Html->link('<i class="fa fa-plus"></i> Agregar Taller', $this->Html->url(array('controller' => 'admin', 'action' => 'add_taller')), array('escape' => false, 'title' => 'Agregar Taller', 'class' => array('btn btn-success fancybox')));
				?>
			</div>
		</div>
		<div class="content pull-left">
			<?php if(isset($talleresBusqueda)){ ?>
				<p class="resultado-busqueda">
					Resultados de busqueda de <span>" <?php echo $nombre; ?> "</span>, haga click <?php echo $this->Html->link('aquí',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres'))); ?> para mosrar todo
				</p>
			<?php } ?>
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Dirección</th>
						<th>Telefono</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$talleres = (isset($talleresBusqueda) ? $talleresBusqueda: $talleresPaginator);
					if(!empty($talleres)){
						foreach($talleres as $taller){ ?>
							<tr>
								<td width="5%"><?php echo $taller['Cliente']['id']; ?></td>
								<td width="20%"><?php echo ucwords($taller['Cliente']['nombre']); ?></td>
								<td width="25%"><?php echo $taller['Correo']['direccion']; ?></td>
								<td width="20%"><?php echo ucwords($taller['Cliente']['direccion']); ?></td>
								<td width="15%"><?php echo $taller['Cliente']['telefono']; ?></td>
								<td width="15%">
									<?php 
									echo $this->Html->link('<i class="fa fa-pencil"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'edit_taller', $taller['Cliente']['id'])), array('escape' => false, 'title' => 'Editar', 'class' => array('btn btn-warning')));
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_taller', $taller['Cliente']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
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
			if(isset($talleresPaginator)){
				echo $this->element('paginador');
			} ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
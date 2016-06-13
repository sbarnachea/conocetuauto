<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Tipos Vehiculos');
?>
<div class="wrapper administrador">
	<div class="contenido">
		<ul class="nav nav-tabs" role="tablist">
			<li>
				<?php echo $this->Html->link('Marcas',$this->Html->url(array('controller' => 'admin', 'action' => 'index'))); ?>
			</li>
			<li class="active">
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
			<li>
				<?php echo $this->Html->link('Talleres',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres'))); ?>
			</li>
			<li>
	 			<?php echo $this->Html->link('Usuarios',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios'))); ?>
			</li>
		</ul>
		<div class="pull-left herramientas">
			<h3><i class="fa fa-gear"></i> Opciones Avanzadas</h3>
			<div class="agregar">
				<?php
					echo $this->Html->link('<i class="fa fa-plus"></i> Agregar Tipo Vehiculo', $this->Html->url(array('controller' => 'admin', 'action' => 'add_tipo_vehiculo')), array('escape' => false, 'title' => 'Agregar Tipo Vehiculo', 'class' => array('btn btn-success')));
				?>
			</div>
		</div>
		<div class="content pull-left">
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody><?php
					if(!empty($tiposVehiculos)){ 
						foreach($tiposVehiculos as $tipo){ ?>
							<tr>
								<td width="5%"><?php echo $tipo['TipoVehiculo']['id']; ?></td>
								<td><?php echo ucwords($tipo['TipoVehiculo']['nombre']); ?></td>
								<td width="15%">
									<?php 
									
									echo $this->Html->link('<i class="fa fa-pencil"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'edit_tipo_vehiculo', $tipo['TipoVehiculo']['id'])), array('escape' => false, 'title' => 'Editar', 'class' => array('btn btn-warning')));
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_tipo_vehiculo', $tipo['TipoVehiculo']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
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
			<?php echo $this->element('paginador'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
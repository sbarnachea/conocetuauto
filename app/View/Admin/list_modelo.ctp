<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Administrador',  array('controller' => 'admin', 'action' => 'index'));
	$this->Html->addCrumb('Modelos de ' . ucwords($marca['Marca']['nombre']));
?>
<div class="wrapper administrador">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'admin', 'action' => 'index')), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Listado Modelos</h3>
		<div class="pull-left herramientas">
			<h3><i class="fa fa-gear"></i> Opciones Avanzadas</h3>
			<div class="agregar">
				<?php
					echo $this->Html->link('<i class="fa fa-plus"></i> Agregar Modelo', $this->Html->url(array('controller' => 'admin', 'action' => 'add_modelo', $marca['Marca']['id'])), array('escape' => false, 'title' => 'Mostrar Todos', 'class' => array('btn btn-success')));
				?>
			</div>
		</div>
		<div class="content pull-left">
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Tipo Vehiculo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(!empty($modelos)){
						foreach($modelos as $modelo){ ?>
							<tr>
								<td width="5%"><?php echo $modelo['Modelo']['id']; ?></td>
								<td width="35%"><?php echo ucwords($modelo['Modelo']['nombre']); ?></td>
								<td width="45%"><?php echo ucwords($modelo['TipoVehiculo']['nombre']); ?></td>
								<td width="15%">
									<?php 
									
									echo $this->Html->link('<i class="fa fa-pencil"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'edit_modelo', $marca['Marca']['id'], $modelo['Modelo']['id'])), array('escape' => false, 'title' => 'Editar', 'class' => array('btn btn-warning')));
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_modelo', $marca['Marca']['id'], $modelo['Modelo']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
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
			<?php echo $this->element('paginador');?>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
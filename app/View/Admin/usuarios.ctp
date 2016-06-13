<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Usuarios');
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
			<li>
				<?php echo $this->Html->link('Talleres',$this->Html->url(array('controller' => 'admin', 'action' => 'talleres'))); ?>
			</li>
			<li class="active">
	 			<?php echo $this->Html->link('Usuarios',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios'))); ?>
			</li>
		</ul>
		<div class="pull-left herramientas">
			<h3><i class="fa fa-gear"></i> Opciones Avanzadas</h3>
			<?php 
				echo $this->Form->create('Persona', array(
					'url' => array('controller' => 'admin', 'action' => 'usuarios'),
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
					echo $this->Html->link('<i class="fa fa-plus"></i> Agregar Usuario', $this->Html->url(array('controller' => 'admin', 'action' => 'add_usuario')), array('escape' => false, 'title' => 'Agregar Usuario', 'class' => array('btn btn-success fancybox')));
				?>
			</div>
		</div>
		<div class="content pull-left">
			<?php if(isset($usuariosBusqueda)){ ?>
				<p class="resultado-busqueda">
					Resultados de busqueda de <span>" <?php echo $nombre; ?> "</span>, haga click <?php echo $this->Html->link('aquí',$this->Html->url(array('controller' => 'admin', 'action' => 'usuarios'))); ?> para mosrar todo
				</p>
			<?php } ?>
			<table class="table table-hover table-marcas pull-left">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Tipo Usuario</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$usuarios = (isset($usuariosBusqueda) ? $usuariosBusqueda: $usuariosPaginator);
					if(!empty($usuarios)){
						foreach($usuarios as $usuario){ ?>
							<tr>
								<td width="5%"><?php echo $usuario['Persona']['id']; ?></td>
								<td width="30%"><?php echo ucwords($usuario['Persona']['nombre'] . ' ' . $usuario['Persona']['paterno'] . ' ' . $usuario['Persona']['materno']); ?></td>
								<td width="25%"><?php echo $usuario['Correo']['direccion']; ?></td>
								<td width="25%"><?php echo ucwords($usuario['User']['TipoUsuario']['nombre']); ?></td>
								<td width="15%">
									<?php 
									echo $this->Html->link('<i class="fa fa-pencil"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'edit_usuario', $usuario['Persona']['id'])), array('escape' => false, 'title' => 'Editar', 'class' => array('btn btn-warning')));
									echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'admin', 'action' => 'delete_usuario', $usuario['Persona']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
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
			if(isset($usuariosPaginator)){
				echo $this->element('paginador');
			} ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
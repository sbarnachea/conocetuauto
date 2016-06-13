<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Mi Publicidad');
?>
<div class="wrapper">
	<div class="anuncios row contenido">
		<div class="col-xs-12">
			<h3>Listado mi publicidad</h3>
			<div class="row">
				<div class="col-xs-4">
					<div class="panel-gris">
						<h4>Reglas</h4>
						<ul>
							<li>Se puede tener un máximo de 2 anuncios activos</li>
							<li>Cada anuncio se activa cuando se reciba el pago</li>
							<li>El anuncio se tiene que renovar cada 30 días</li>
						</ul>
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> Agregar Publicidad', $this->Html->url(array('controller' => 'anuncio', 'action' => 'add')), array('escape' => false, 'class' => 'btn btn-success btn-block')); ?>
					</div>
				</div>
				<div class="col-xs-8">
					<table class="table table-hover pull-left">
						<thead>
							<tr>
								<th>#</th>
								<th>Titulo</th>
								<th>Fecha Termino</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($anuncios as $anuncio){ ?>
							<tr>
								<td width="5%"><?php echo $anuncio['Anuncio']['id']; ?></td>
								<td width="35%"><?php echo $anuncio['Anuncio']['titulo']; ?></td>
								<td width="25%"><?php 
									if($anuncio['Anuncio']['estado'] == 1){
										$nuevafecha = strtotime ( '+30 day' , strtotime ( $anuncio['Anuncio']['fecha_inicio'] ) ) ;
										$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
										echo $nuevafecha; 
									}?>
								</td>
								<td width="20%"><?php 
									if($anuncio['Anuncio']['estado'] == 0){
										echo 'Espera de Pago';
									}elseif($anuncio['Anuncio']['estado'] == 1){
										echo 'Aprobado';
									}elseif($anuncio['Anuncio']['estado'] == 2){
										echo 'Finalizado';
									} ?>
								</td>
								<td width="15%"><?php 
									echo $this->Html->link('<i class="fa fa-pencil"></i>', $this->Html->url(array('controller' => 'anuncio', 'action' => 'edit', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Editar', 'class' => array('btn btn-warning')));
									if($anuncio['Anuncio']['estado'] == 2){
										echo $this->Html->link('<i class="fa fa-refresh"></i>', $this->Html->url(array('controller' => 'anuncio', 'action' => 'renovar', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Renovar', 'class' => array('btn btn-info')));
									}
									if($anuncio['Anuncio']['estado'] == 0){
										echo $this->Html->link('<i class="fa fa-minus"></i>', $this->Html->url(array('controller' => 'anuncio', 'action' => 'delete', $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Eliminar', 'class' => array('btn btn-danger')));
									}
									if($anuncio['Anuncio']['estado'] == 1){
										echo $this->Html->link('<i class="fa fa-eye"></i>', $this->Html->url(array('controller' => 'anuncio', 'action' => 'detalle', $anuncio['Anuncio']['id_cliente'], $anuncio['Anuncio']['id'])), array('escape' => false, 'title' => 'Ver', 'class' => array('btn btn-primary'), 'target' => '_blank'));
									}?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
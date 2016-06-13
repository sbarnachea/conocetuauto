<?php foreach($fallas as $falla){ ?>
<a href="<?php echo $this->Html->url(array('controller' => 'falla', 'action' => 'detalle', $falla['Falla']['id'])); ?>" class="item">
	<div class="panel-gris row">
		<div class="info pull-left col-xs-2">
			<h5><?php echo ucfirst($falla['Vehiculo']['Marca']['nombre']) . ' ' . ucwords($falla['Vehiculo']['Modelo']['nombre']); ?></h5>
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
		<div class="pull-right">
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
<?php } ?>
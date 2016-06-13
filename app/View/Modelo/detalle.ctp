<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas', array('controller' => 'marca', 'action' => 'index'));
	$this->Html->addCrumb('Modelos ' . ucwords($modelo['Marca']['nombre']), array('controller' => 'modelo', 'action' => 'index', $modelo['Marca']['id']));
	$this->Html->addCrumb('Detalle ' . ucwords($modelo['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']));?>
<div class="wrapper">
	<div class="contenido">
		<?php echo $this->Html->link('<i class="fa fa-chevron-left"></i> Volver', $this->Html->url(array('controller' => 'modelo', 'action' => 'index', $modelo['Marca']['id'])), array('class' => array('btn btn-primary'), 'escape' => false)); ?>
		<h3>Información <?php echo ucwords($modelo['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']); ?></h3>
		<div class="modelo-detalle row">
			<div class="col-xs-6">
				<div class="bar fallas pull-left">
					<h4>Tipos de Fallas más comúnes</h4>
					<?php if(!empty($tiposFallas)){ ?>
						<div>
							<canvas id="tipo-falla" height="300" width="515"></canvas>
						</div>
					<?php }else{ ?>
						<div class="comparte">
							<p>Nadie ha compatido su comentario negativo para este modelo, se tú el primero</p>
							<?php echo $this->Html->link('<i class="fa fa-plus"></i> Comparte tu opinión', $this->Html->url(array('controller' => 'falla', 'action' => 'add', $modelo['Marca']['id'], $modelo['Modelo']['id'])), array('class' => array('btn btn-success'), 'escape' => false)); ?>
						</div>
					<?php } ?>
				</div>
				<div class="pull-left resumen">
					<h4><?php echo ucwords($modelo['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']); ?></h4>
					<ul>
						<li><span><?php echo $total[0][0]['personas']; ?></span> <?php echo ($total[0][0]['personas'] > 2 ? 'personas han': 'persona ha'); ?> compartido su experiencia</li>
						<?php if(!empty($tiposFallas)){ ?>
							<li><span><?php echo $tiposFallas[0]['TipoFalla']['nombre']; ?></span> es la falla mas común</li>
						<?php }
						if(!empty($anoVehiculo)){ ?>
							<li><span><?php echo $anoVehiculo[0]['Vehiculo']['ano']; ?></span> el año del modelo con más falla</li>
						<?php } ?>
					</ul>
				</div>
				<div class="comentarios">
					<?php if(!empty($fallas)){ ?>
						<h3 class="pull-left">Ultimos Comentarios compartidos</h3> 
						<span class="pull-right">
							<?php echo $this->Html->link('Ver todas', $this->Html->url(array('controller' => 'falla', 'action' => 'listado', $modelo['Marca']['id'], $modelo['Modelo']['id']))); ?>
						</span>
						<div class="clearfix"></div>
						<?php foreach($fallas as $falla){ ?>
							<a href="<?php echo $this->Html->url(array('controller' => 'falla', 'action' => 'detalle', $modelo['Marca']['id'], $modelo['Modelo']['id'], $falla['Falla']['id'])); ?>">
								<div class="panel-gris row">
									<div class="info pull-left col-xs-2">
										<h5><?php echo (isset($falla['User']['Persona'][0]['nombre'])? $falla['User']['Persona'][0]['nombre']: $falla['Falla']['nick']); ?></h5>
										<p><?php echo  date('d-m-Y H:i', strtotime($falla['Falla']['created']));?></p>
									</div>
									<div class="descripcion pull-left col-xs-10">
										<span><?php echo ucfirst($falla['TipoFalla']['nombre']); ?></span>
										<h5><?php echo ucfirst($falla['Falla']['titulo']); ?></h5>
										<p><?php echo nl2br(ucfirst($falla['Falla']['descripcion'])); ?></p>
									</div>
									<div class="clearfix"></div>
									<div class="pull-left">
										Denunciar
									</div>
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
						<?php } 
					}?>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="nueva-falla pull-left">
					<h4>¿Tu auto falla?</h4>
					<p>Comparte tu problema o experiencia con nosotros</p>
					<?php echo $this->Html->link('<i class="fa fa-plus"></i> Comparte tu opinión', $this->Html->url(array('controller' => 'falla', 'action' => 'add', $modelo['Marca']['id'], $modelo['Modelo']['id'])), array('class' => array('btn btn-success'), 'escape' => false)); ?>
				</div>
				<div class="clearfix"></div>
				<?php 
				echo $this->element('anuncio-horizontal');
				
				if(!empty($anoVehiculo)){ ?>
					<div class="ano-vehiculo pull-left">
						<div class="pie">
							<h4>Años del modelo con mas Fallas</h4>
							<canvas id="ano-modelo" width="450" height="300"/>
						</div>
					</div>
				<?php } 
				if($fallasNegativa[0][0]['total'] > 0 || $fallasPositiva[0][0]['total'] > 0){ ?>
					<div class="tipo-comentario-donut pie pull-left">
						<h4>Tipo de comentarios</h4>
						<canvas id="tipo-comentario" width="300" height="300"/>
					</div>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
var tipocomentario = [
	<?php
	if($fallasNegativa[0][0]['total'] > 0){
		echo '{
			value:' . $fallasNegativa[0][0]['total'] . ',
			color:"rgba(217,83,79,0.6)",
			highlight: "rgba(217,83,79,1)",
			label:"Negativo"
		},';
	} 
	if($fallasPositiva[0][0]['total'] > 0){
		echo '{
			value:' . $fallasPositiva[0][0]['total'] . ',
			color:"rgba(92,184,92,0.6)",
			highlight: "rgba(92,184,92,1)",
			label:"Positivo"
		}';
	} ?>
];
var anomodelo = {
	labels : [<?php foreach ($anoVehiculo as $vehiculo) { echo '"' . $vehiculo['Vehiculo']['ano'] . '",';} ?>],
	datasets : [
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,0.8)",
			highlightFill : "rgba(151,187,205,0.75)",
			highlightStroke : "rgba(151,187,205,1)",
			data : [<?php foreach ($anoVehiculo as $vehiculo) { echo $vehiculo[0]['total'] . ',';} ?>]
		}
	]
};
var tipofalla = {
	labels : [<?php foreach ($tiposFallas as $tipoFalla) { echo '"' . $tipoFalla['TipoFalla']['nombre'] . '",';} ?>],
	datasets : [
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,0.8)",
			highlightFill : "rgba(151,187,205,0.75)",
			highlightStroke : "rgba(151,187,205,1)",
			data : [<?php foreach ($tiposFallas as $tipoFalla) { echo $tipoFalla[0]['numero'] . ',';} ?>]
		}
	]
}
window.onload = function(){
	<?php if(!empty($anoVehiculo)){ ?>
		var tipo_falla = document.getElementById("tipo-falla").getContext("2d");
		window.myBar = new Chart(tipo_falla).Bar(tipofalla, {
			responsive : true
		});
	<?php }
	if(!empty($anoVehiculo)){ ?>
		var ano_modelo = document.getElementById("ano-modelo").getContext("2d");
		window.myPie = new Chart(ano_modelo).Bar(anomodelo);
	<?php } 
	if($fallasNegativa[0][0]['total'] > 0 || $fallasPositiva[0][0]['total'] > 0){?>
		var tipo_comentario = document.getElementById("tipo-comentario").getContext("2d");
		window.myPie = new Chart(tipo_comentario).Doughnut(tipocomentario);
	<?php } ?>
}

</script>
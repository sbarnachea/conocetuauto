<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres', array('controller' => 'talleres'));
	$this->Html->addCrumb('Detalle');
?>
<div class="wrapper">
	<div class="detalle-taller">
		<div class="row">
			<div class="col-xs-7">
				<h3><?php echo $cliente['Cliente']['nombre']; ?></h3>
				<div class="panel-gris">
					<div class="row detalle">
						<div class="col-xs-4">
							<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/'. (!empty($cliente['Cliente']['imagen'])? $cliente['Cliente']['imagen']: 'taller.jpg'), array('class' => 'pull-left')); ?>
						</div>
						<div class="col-xs-8">
							<div class="pull-left row">
								<div class="col-xs-4">
									Dirección
								</div>
								<div class="col-xs-8">
									<?php echo ucwords($cliente['Cliente']['direccion']); ?>
								</div>
								<div class="col-xs-4">
									Región
								</div>
								<div class="col-xs-8">
									<?php echo ucwords($cliente['Region']['nombre']); ?>
								</div>
								<div class="col-xs-4">
									Comuna
								</div>
								<div class="col-xs-8">
									<?php echo ucwords($cliente['Comuna']['nombre']); ?>
								</div>
								<div class="col-xs-4">
									Telefono
								</div>
								<div class="col-xs-8">
									<?php echo $cliente['Cliente']['telefono']; ?>
								</div>
								<div class="col-xs-4">
									Correo
								</div>
								<div class="col-xs-8">
									<?php echo $cliente['Correo']['direccion']; ?>
								</div>
								<div class="col-xs-4">
									Valoración
								</div>
								<div class="col-xs-8">
									<?php 
									if(isset($cliente['Valoracion'][0]['Valoracion'][0]['promedio'])){
										$count = 1;
										while ($count <= round($cliente['Valoracion'][0]['Valoracion'][0]['promedio'])) { ?>
											<i class="fa fa-star pull-left"></i>
										<?php $count++;
										}
									} ?>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php if(!empty($valoracion)){ ?>
					<h3>Tu valoración</h3>
					<div class="panel-gris">
						Tu votación es importante para que los demás usuarios sepan como es este taller
						<div class="valoracion">
							<?php 
							$count = 1;
							while ($count <= 5) {
								if($count <= $valoracion['Valoracion']['estrellas']){ ?>
									<i class="fa fa-star pull-left select" id="<?php echo $count; ?>"></i>

								<?php }else{ ?>
									<i class="fa fa-star-o pull-left" id="<?php echo $count; ?>"></i>
								<?php }
								$count++;
							} ?>
						</div>					
					</div>
				<?php }elseif($this->Session->check('Auth.User.id') && $this->Session->read('Auth.User.id_tipo_usuario') != 2){ ?>
					<h3>Valora este taller</h3>
					<div class="panel-gris">
						Tu votación es importante para que los demás usuarios sepan como es este taller
						<div class="valoracion">
							<?php 
							$count = 1;
							while ($count <= 5) { ?>
									<i class="fa fa-star-o pull-left" id="<?php echo $count; ?>"></i>
								<?php $count++;
							} ?>
						</div>					
					</div>
				<?php } ?>
			</div>
			<div class="col-xs-5">
				<div class="como-llegar">
					<span>Cómo llegar</span>
					<div class="mapa">
						<div id='map_canvas' style="width:447px; height:400px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var estrellaP = <?php echo (!empty($valoracion) ? $valoracion['Valoracion']['estrellas']: 0); ?>;
$('.valoracion i').hover(
	function(){
		$('.valoracion i').each(function(){
			$(this).removeClass('select');
			$(this).removeClass('select-virtual');
			$(this).removeClass('fa-star');
			$(this).addClass('fa-star-o');
		});
		var contador = $(this).attr('id');
		while(contador >= 0){
			$('.valoracion i#' + contador).removeClass('fa-star-o');
			$('.valoracion i#' + contador).addClass('fa-star');
			$('.valoracion i#' + contador).addClass('select-virtual');
			contador--;
		}
	}, function(){
		$('.valoracion i').each(function(){
			$(this).removeClass('select');
			$(this).removeClass('select-virtual');
			$(this).removeClass('fa-star');
			$(this).addClass('fa-star-o');
		});
		var contador = 1;
		while(contador <= estrellaP){
			$('.valoracion i#' + contador).addClass('select');
			$('.valoracion i#' + contador).addClass('fa-star');
			$('.valoracion i#' + contador).removeClass('fa-star-o');
			contador++;
		}
	}
);
$('.valoracion i').click(function(){
	var estrellas = $(this).attr('id');
	$.get( "/cliente/votar/" + <?php echo $cliente['Cliente']['id']; ?> + "/" + <?php echo $this->Session->read('Auth.User.id'); ?> + "/" + $(this).attr('id') , function( data ) {
		if(data.status == 'success'){
			var contador = 1;
			$('.valoracion i').each(function(){
				$(this).removeClass('select');
				$(this).removeClass('select-virtual');
				$(this).removeClass('fa-star');
				$(this).addClass('fa-star-o');
			});
			estrellaP = estrellas;
			while(contador <= estrellas){
				$('.valoracion i#' + contador).addClass('select');
				$('.valoracion i#' + contador).addClass('fa-star');
				$('.valoracion i#' + contador).removeClass('fa-star-o');
				contador++;
			}
			$('.alertas').append('<div id="flashMessage" class="alert alert-info alert-index">Votación guardada correctamente</div>');
		}else{
			$('.alertas').append('<div id="flashMessage" class="alert alert-danger alert-index">Ocurrio un problema, intentalo nuevamente</div>')
		}
	}, "json" );
});

$(document).ready(function() {
	var address = '<?php echo $cliente['Cliente']['direccion']; ?>, <?php echo $cliente['Comuna']['nombre']; ?>';
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({ 'address': address}, geocodeResult);
});

var map; 
function geocodeResult(results, status) {
	if (status == 'OK') {
		var mapOptions = {
			center: results[0].geometry.location,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map($("#map_canvas").get(0), mapOptions);
		map.fitBounds(results[0].geometry.viewport);
		var markerOptions = { position: results[0].geometry.location }
		var marker = new google.maps.Marker(markerOptions);
		marker.setMap(map);
	} else {
		alert("Geocoding no tuvo éxito debido a: " + status);
	}
}
</script>
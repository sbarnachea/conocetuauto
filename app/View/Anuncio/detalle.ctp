<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres', array('controller' => 'talleres'));
	$this->Html->addCrumb(ucwords($cliente['Cliente']['nombre']), array('controller' => 'cliente', 'action' => 'detalle', $cliente['Cliente']['id']));
	$this->Html->addCrumb($anuncio['Anuncio']['titulo']);
?>
<div class="wrapper">
	<div class="detalle-taller">
		<div class="row">
			<div class="col-xs-7">
				<h3><?php echo $anuncio['Anuncio']['titulo']; ?></h3>
				<div class="detalle-anuncio">
					<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/anuncio/' . $anuncio['Anuncio']['imagen_horizontal'], array()); ?>
					<div class="descripcion">
						<h4>Descripción</h4>
						<p><?php echo nl2br(ucfirst($anuncio['Anuncio']['descripcion'])); ?></p>
					</div>
				</div>
				<div class="panel-gris">
					<div class="row detalle">
						<div class="col-xs-4">
							<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/'. (!empty($cliente['Cliente']['imagen'])? $cliente['Cliente']['imagen']: 'taller.jpg'), array('class' => 'pull-left')); ?>
						</div>
						<div class="col-xs-8">
							<div class="pull-left row">
								<div class="col-xs-4">
									Taller
								</div>
								<div class="col-xs-8">
									<?php echo ucwords($cliente['Cliente']['nombre']); ?>
								</div>
								<div class="col-xs-4">
									Dirección
								</div>
								<div class="col-xs-8">
									<?php echo ucwords($cliente['Cliente']['direccion']) . ', ' . ucwords($cliente['Comuna']['nombre']); ?>
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
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
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
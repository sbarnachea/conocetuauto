<div class="empresa">
	<div class="section1">
		<div class="wrapper">
			<div class="section1-a">
				<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/logo-principal.png'); ?>
				<h2>Talleres</h2>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="section2">
		<div class="wrapper">
			<div class="separator"></div>
			<div class="section2-a">
				<h2>Únete y accede a todos los beneficios que Conoce tu auto tiene para tu taller</h2>
				<div class="row lista">
					<div class="col-xs-6">
						<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/publicidad.png'); ?>
						<p><i class="fa fa-check"></i> Podrás darte a conocer dentro de los usuarios que tienen fallas, administrando tu publicidad, pagada mensualmente.</p>
					</div>
					<div class="col-xs-6">
						<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/ayudar.png'); ?>
						<p><i class="fa fa-check"></i> Puedes ayudar a los usuarios dandole recomendaciones de lo que deben hacer o invitandolos a ir a tu taller</p>
					</div>
					<div class="col-xs-6">
						<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/ranking.png'); ?>
						<p><i class="fa fa-check"></i> Al invitar a los usuarios a tu taller ellos podrán valorar tu atención y tu taller podrá aparecer en el ranking de mejores talleres.</p>
					</div>
					<div class="col-xs-6">
						<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/perfil.png'); ?>
						<p><i class="fa fa-check"></i> Podrás tener un perfil de tu taller, con tus datos de contacto y mapa de como llegar</p>
					</div>
				</div>
				<ul>
					<li>Por qué podrás darte a conocer dentro de los usuarios que tienen fallas, administrando tu publicidad, pagada mensualmente.</li>
					<li>Puedes ayudar con comentarios de la falla a usuarios que no saben que hacer con su vehículo.</li>
					<li>Al invitar a los usuarios a tu taller, luego ellos podrán valorar tu atención y aparecer en el ranking de mejores talleres.</li>
					<li>Podrás tener un perfil de tu taller, con dirección, telefono, correo y mapa de como llegar</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
	var $win = $(window);
	var $pos = 240;
	$win.scroll(function () {
		if ($win.scrollTop() >= $pos)
			$('.navbar-menu .logo img').removeClass('hide');
		else {
			$('.navbar-menu .logo img').addClass('hide');
		}
	});
});
</script>
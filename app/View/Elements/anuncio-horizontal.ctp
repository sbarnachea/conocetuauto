<?php if(!empty($anuncio)){ ?>
	<a class="publicidad-horizontal" href="<?php echo $this->Html->url(array('controller' => 'anuncio', 'action' => 'detalle', $anuncio['Cliente']['id'], $anuncio['Anuncio']['id'])); ?>">
		<div class="fade"></div>
		<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/anuncio/' . $anuncio['Anuncio']['imagen_horizontal'], array()); ?>
		<span class="pull-right">Anuncio</span>
	</a>
<?php } ?>
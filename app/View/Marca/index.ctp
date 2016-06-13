<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas');
?>
<div class="wrapper">
	<div class="contenido row">
		<div class="col-xs-12">
			<h3>Selecciona la marca de tu vehiculo</h3>
			<div class="marcas">
				<?php foreach ($marcasPortada as $marca) {  ?>
					<div class="item pull-left">
						<?php echo $this->Html->link($this->Html->image(Configure::read('App.staticUrl') . 'img/marca/resize/' . $marca['Marca']['imagen']),$this->Html->url(array('controller' => 'modelo', 'action' => 'index', $marca['Marca']['id'])), array('escape' => false, 'title' => ucwords($marca['Marca']['nombre']))); ?>
					</div>	
				<?php }
				
				foreach ($marcas as $marca) { ?>
					<div class="item small pull-left">
						<?php echo $this->Html->link($this->Html->image(Configure::read('App.staticUrl') . 'img/marca/resize/' . $marca['Marca']['imagen']),$this->Html->url(array('controller' => 'modelo', 'action' => 'index', $marca['Marca']['id'])), array('escape' => false, 'title' => ucwords($marca['Marca']['nombre']))); ?>
					</div>	
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
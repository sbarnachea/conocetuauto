<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Mi Publicidad', array('controller' => 'anuncio', 'action' => 'index'));
	$this->Html->addCrumb('Editar publicidad');
?>
<div class="wrapper">
	<div class="anuncios row">
		<div class="col-xs-12">
			<h3>Editar publicidad</h3>
			<div class="row">
				<div class="col-xs-8">
					<?php 
					echo $this->Form->create('Anuncio', array(
						'url' => array('controller' => 'anuncio', 'action' => 'edit', $anuncio['Anuncio']['id']),
						'type' => 'file',
						'class' => 'pull-left formulario'
					));
					echo $this->Form->input('id', array('type' => 'hidden', 'value' => $anuncio['Anuncio']['id']))
					?>
					<table class="table-anuncio">
						<tr>
							<td>Titulo</td>
							<td><?php echo $this->Form->input('titulo', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'value' => $anuncio['Anuncio']['titulo'])); ?></td>
						</tr>
						<tr>
							<td>Imágen 1</td>
							<td>
								<?php echo $this->Form->input('imagen', array('type' => 'file', 'label' => false));?>
								<span>(imágen debe tener el tamaño 330px Ancho y 440px de Alto)</span>
							</td>
						</tr>
						<tr>
							<td>Imágen 2</td>
							<td>
								<?php echo $this->Form->input('imagen_horizontal', array('type' => 'file', 'label' => false)); ?>
								<span>(imágen debe tener el tamaño 550px Ancho y 200px de Alto)</span>
							</td>
						</tr>
						<tr>
							<td>Descripción</td>
							<td><?php echo $this->Form->input('descripcion', array('class' => 'form-control', 'type' => 'textarea', 'required' => true, 'label' => false, 'value' => $anuncio['Anuncio']['descripcion'])); ?></td>
						</tr>
					</table>
					<?php
						echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); 
					?>
				</div>
			</div>
		</div>
	</div>
</div>
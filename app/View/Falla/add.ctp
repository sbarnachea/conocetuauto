<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Marcas', array('controller' => 'marca', 'action' => 'index'));
	$this->Html->addCrumb('Modelos ' . ucwords($marca['Marca']['nombre']), array('controller' => 'modelo', 'action' => 'index', $marca['Marca']['id']));
	$this->Html->addCrumb('Detalle ' . ucwords($marca['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']), array('controller' => 'modelo', 'action' => 'detalle', $marca['Marca']['id'], $modelo['Modelo']['id']));
	$this->Html->addCrumb('Ingresar Falla');

	$años = array();
	$añoComienzo = (date('m') >= 8 ?  date('Y') + 1 : date('Y'));

	for($i = 50; $i > 0; $i--){
		$años[$añoComienzo] = $añoComienzo;
		$añoComienzo--;
	}

?>
<div class="wrapper">
	<div class="contenido falla">
		<h3>Comparte tu experiencia con nosotros</h3>
		<h4> de tu <?php echo ucwords($marca['Marca']['nombre'] . ' ' . $modelo['Modelo']['nombre']); ?></h4>
		<?php 
			echo $this->Form->create('Falla', array(
				'url' => array('controller' => 'falla', 'action' => 'add', $marca['Marca']['id'], $modelo['Modelo']['id']),
				'class' => 'pull-left formulario'
			)); 
			echo $this->Form->input('Vehiculo.id_marca', array('type' => 'hidden', 'value' => $marca['Marca']['id']));
			echo $this->Form->input('Vehiculo.id_modelo', array('type' => 'hidden', 'value' => $modelo['Modelo']['id']));
			echo $this->Form->input('id_usuario', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
			?>
			<table class="table-falla">
				<tr>
					<td>Tipo Comentario</td>
					<td>
						<?php echo $this->Form->input('tipo_comentario', array('type' => 'hidden', 'value' => 1)); ?>
						<div class="btn-group btn-toggle"> 
							<div class="btn btn-lg btn-danger active" data-tipo="negativo">Negativo</div>
							<div class="btn btn-lg btn-default" data-tipo="positivo">Positivo</div>
						</div>
						<div class="explicacion"> 
							<p class="negativo">Negativo: Cuentanos en que ha fallado tu vehiculo</p>
							<p class="positivo">Positivo: Cuentanos porque tu vehiculo es el mejor</p>
						</div>
					</td>
				</tr>
				<tr class="tipofalla">
					<td>Tipo de Falla</td>
					<td><?php echo $this->Form->input('id_tipo_falla', array('class' => 'form-control', 'options' => $tiposFallas, 'required' => true, 'label' => false, 'empty' => 'Seleccionar Tipo de Falla')); ?></td>
				</tr>
				<tr>
					<td>Año Vehiculo</td>
					<td><?php echo $this->Form->input('Vehiculo.ano', array('class' => 'form-control', 'required' => true, 'label' => false, 'options' => $años, 'empty' => 'Seleccionar Año del modelo')); ?></td>
				</tr>
				<tr>
					<td>Titulo</td>
					<td><?php echo $this->Form->input('titulo', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td>Descripción</td>
					<td><?php echo $this->Form->input('descripcion', array('class' => 'form-control', 'type' => 'textarea', 'required' => true, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div class="g-recaptcha" data-sitekey="6LdRuw0TAAAAAL_EXkAgX6vHxS0AygWvlnQxrYXs"></div>
					</td>
				</tr>
			</table>

			<?php
			echo $this->Html->link('Cancelar',$this->Html->url(array('controller' => 'modelo', 'action' => 'detalle', $marca['Marca']['id'], $modelo['Modelo']['id'])), array('class' => 'pull-left cancelar'));
			echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); ?>
			<div class="clearfix"></div>
	</div>
</div>

<?php 
	$años = array();
	$añoComienzo = (date('m') >= 8 ?  date('Y') + 1 : date('Y'));

	for($i = 50; $i > 0; $i--){
		$años[$añoComienzo] = $añoComienzo;
		$añoComienzo--;
	}
?>
<div class="wrapper">
	<div class="header">
		<div class="logo">
			<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/logo-principal.png'); ?>
			<h2>Ayúdanos contestando esta simple encuesta</h2>
			<p>Con tu ayuda será posible crear un nuevo sitio, el cual te permitirá conocer y compartir experiencias con distintos usuarios y sus vehículos. Por ello te pedimos que completes el siguiente formulario.</p>
		</div>
	</div>
</div>
<div class="encuesta">
	<div class="wrapper">
		<div class="separator"></div>
		<?php 
			echo $this->Form->create('Falla', array(
				'url' => array('controller' => 'home', 'action' => 'encuesta'),
				'class' => 'pull-left formulario',
				'onsubmit' => 'return formulario()'
			)); 
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
							<p class="negativo">Negativo: Cuéntanos en que ha fallado tu vehículo</p>
							<p class="positivo">Positivo: Cuéntanos por qué tu vehículo es el mejor</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>Marca</td>
					<td><?php echo $this->Form->input('Vehiculo.id_marca', array('class' => 'form-control', 'options' => $marcas, 'required' => true, 'label' => false, 'empty' => 'Seleccionar Marca')); ?></td>
				</tr>
				<tr>
					<td>Modelo</td>
					<td><?php echo $this->Form->input('Vehiculo.id_modelo', array('class' => 'form-control', 'options' => array(), 'required' => true, 'label' => false, 'empty' => 'Seleccionar Modelo')); ?></td>
				</tr>
				<tr>
					<td>Año Vehiculo</td>
					<td><?php echo $this->Form->input('Vehiculo.ano', array('class' => 'form-control', 'required' => true, 'label' => false, 'options' => $años, 'empty' => 'Seleccionar Año del modelo')); ?></td>
				</tr>
				<tr class="tipofalla">
					<td>Tipo de Falla</td>
					<td><?php echo $this->Form->input('id_tipo_falla', array('class' => 'form-control', 'options' => $tiposFallas, 'label' => false, 'empty' => 'Seleccionar Tipo de Falla')); ?></td>
				</tr>
				<tr>
					<td>Tu Nombre</td>
					<td><?php echo $this->Form->input('nick', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'placeholder' => 'Tu nombre')); ?></td>
				</tr>
				<tr>
					<td>Título</td>
					<td><?php echo $this->Form->input('titulo', array('class' => 'form-control', 'type' => 'text', 'required' => true, 'label' => false, 'placeholder' => 'Titulo de tu comentario')); ?></td>
				</tr>
				<tr>
					<td>Descripción</td>
					<td><?php echo $this->Form->input('descripcion', array('class' => 'form-control', 'type' => 'textarea', 'required' => true, 'label' => false, 'placeholder' => 'Descripción del comentario')); ?></td>
				</tr>
			</table>

			<?php
			echo $this->Form->end(array('label' => 'Guardar','class' => 'btn btn-primary pull-right')); 	
		?>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">

function formulario() { 
	if($.trim($('#FallaEncuestaForm input[name="data[Falla][nick]"]').val()) == ''){
		alert('Falta ingresar tu nombre');
		return false;
	}
	if($.trim($('#FallaEncuestaForm input[name="data[Falla][titulo]"]').val()) == ''){
		alert('Falta ingresar el titulo');
		return false;
	}
	if($.trim($('#FallaEncuestaForm textarea[name="data[Falla][descripcion]"]').val()) == ''){
		alert('Falta ingresar la descripción');
		return false;
	}
	return true; 
}

$(document).ready(function(){ 
	$('.btn-toggle').click(function() {
		if($(this).find('.btn.active').attr('data-tipo') == 'negativo'){
			$(this).find('.btn.active').removeClass('btn-danger');
		}else{
			$(this).find('.btn.active').removeClass('btn-success');
		}
		$(this).find('.btn.active').addClass('btn-default');
		$(this).find('.btn').toggleClass('active');  

		if($(this).find('.btn.active').attr('data-tipo') == 'positivo'){
			$(this).parent().find('.explicacion .negativo').hide();
			$(this).parent().find('.explicacion .positivo').show();
			$(this).find('.btn.active').addClass('btn-success');
			$('#FallaTipoComentario').attr('value', 0);
			$('.tipofalla').hide();
			$('.tipofalla select').attr('disabled', true);

		}else{
			$(this).parent().find('.explicacion .positivo').hide();
			$(this).parent().find('.explicacion .negativo').show();
			$(this).find('.btn.active').addClass('btn-danger');
			$('#FallaTipoComentario').attr('value', 1);
			$('.tipofalla').show();
			$('.tipofalla select').attr('disabled', false);
		}  
	});
});

$('#VehiculoIdMarca').change(function(){
	$.get( "/home/get_modelos/" + $(this).val() , function( data ) {
		$("#VehiculoIdModelo option").remove();
		$("#VehiculoIdModelo").append("<option value='0'>Seleccionar Modelo</option>");
		$.each(data, function(id, nombre){
			$("#VehiculoIdModelo").append("<option value=\""+id+"\">"+nombre+"</option>");
		});
	}, "json" );
});
</script>
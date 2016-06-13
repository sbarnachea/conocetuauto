<?php 
	$this->Html->addCrumb('Inicio', array('controller' => 'home', 'action' => 'index'));
	$this->Html->addCrumb('Talleres');
?>
<div class="wrapper">
	<div class="contenido row">
		<div class="col-xs-12">
			<h3>Talleres Mécanicos</h3>
			<div class="row taller-listado">
				<?php 
				foreach($ranking as $taller){ ?>
					<div class="col-xs-6">
						<a href="<?php echo $this->Html->url(array('controller' => 'cliente', 'action' => 'detalle', $taller['Cliente']['Cliente']['id'])); ?>">
							<div class="cliente panel-gris">
								<div class="pull-right estrellas">
									<?php 
									if(isset($taller['promedio'])){
										for($i = 0; $i < $taller['promedio']; $i++){ ?>
											<i class="fa fa-star pull-left"></i>
										<?php } 
									}?>
								</div>
								<h4><?php echo $taller['Cliente']['Cliente']['nombre']?></h4>
								<div class="row">
									<div class="col-xs-5">
										<?php echo $this->Html->image(Configure::read('App.staticUrl') . 'img/cliente/'. (!empty($taller['Cliente']['Cliente']['imagen'])? $taller['Cliente']['Cliente']['imagen']: 'taller.jpg'), array('class' => 'pull-left')); ?>
									</div>
									<div class="col-xs-7">
										<div class="informacion pull-left row">
											<div class="col-xs-5">
												Dirección
											</div>
											<div class="col-xs-7">
												<?php echo ucwords($taller['Cliente']['Cliente']['direccion']); ?>
											</div>
											<div class="col-xs-5">
												Comuna
											</div>
											<div class="col-xs-7">
												<?php echo ucwords($taller['Cliente']['Comuna']['nombre']); ?>
											</div>
											<div class="col-xs-5">
												Telefono
											</div>
											<div class="col-xs-7">
												<?php echo $taller['Cliente']['Cliente']['telefono']; ?>
											</div>
											<div class="col-xs-5">
												Correo
											</div>
											<div class="col-xs-7">
												<?php echo $taller['Cliente']['Correo']['direccion']; ?>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
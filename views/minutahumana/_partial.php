<?php 
	use yii\helpers\Url;
	date_default_timezone_set ( 'America/Bogota');
?>
<div class="table-responsive">
<table class="table table-striped">
	<thead>
		
		<tr class="success">
			<th style="text-align: center;"></th>
			<th style="text-align: center;">Cedula</th>	
			<th style="text-align: center;">Persona</th>
			<th style="text-align: center;">Tipo Invitado</th>
			<th style="text-align: center;">Area</th>
			<!-- <th style="text-align: center;">Hora Entrada</th>	
			<th style="text-align: center;">Hora Salida</th> -->
			<th style="text-align: center;">Puesto</th>
			<th style="text-align: center;">Fecha</th>	
			<!-- <th style="text-align: center;">Empresa</th> -->
			<!-- <th style="text-align: center;">Dependencia</th>	 -->
			<!-- <th style="text-align: center;">Usuario</th> -->
			<!-- <th style="text-align: center;">Observacion adicional</th>	
			<th style="text-align: center;">Observacion salida</th>	 -->
				
		</tr>
	</thead>
	<tbody>
		<?php 
		$i=0;
		$fecha_actual=date('Y-m-d');
		foreach($query as $row):
		?>
		<tr>
			<td>	

				<?php if($row['hora_salida']=='00:00:00') :?>
				
				<!-- <button class="btn btn-success btn-xs" data-target="#myModal-salida" data-toggle="modal" onclick="asignar(<?= $row["id"] ?>)">
					<i class="fa fa-check"></i> Salida
				</button>
				 -->
				<?php endif;?>

				<button class="btn btn-success btn-xs" onclick="open_row(<?=$i?>);" id="open_row<?=$i?>">
					<i class="fa fa-plus"></i>
				</button>

				<button class="btn btn-danger btn-xs" onclick="close_row(<?=$i?>);" style="display: none;" id="close_row<?=$i?>">
					<i class="fa fa-minus"></i>
				</button>
			</td>
			<td style="text-align: center;"><?php echo $row['cedula_persona'] ?></td>
			<td style="text-align: center;"><?php echo $row['Persona'] ?></td>
			<td style="text-align: center;"><?php echo $row['tipo_invitado'] ?></td>
			<td style="text-align: center;"><?php echo $row['tipo_observacion'] ?></td>
			<!-- <td style="text-align: center;"><?php echo $row['hora_entrada'] ?></td>
			<td style="text-align: center;"><?php echo $row['hora_salida'] ?></td> -->
			<td style="text-align: center;"><?php echo $row['puesto'] ?></td>
			<td style="text-align: center;"><?php echo $fecha_actual ?></td>
			<!-- <td style="text-align: center;"><?php //echo $row['empresa'] ?></td> -->
			<!-- <td style="text-align: center;"><?php echo $row['dependencia'] ?></td>
			<td style="text-align: center;"><?php echo $row['usuario'] ?></td>
			<td style="text-align: center;"><?php echo $row['observacion'] ?></td>
			<td style="text-align: center;"><?php echo $row['observacion_salida'] ?></td> -->
			
		</tr>

		<tr id="min<?= $i?>" style="display:none;">

			<td colspan="7">
				<h3 class="text-center"><i class="fa fa-calendar"></i> : <?php echo $fecha_actual ?></h3>
				<table class="table table-striped table-bordered">
					<thead>
		
						<tr class="danger">
							<th style="text-align: center;"></th>
							<th style="text-align: center;">H/S</th>	
							<th style="text-align: center;">Fecha</th>
							<th style="text-align: center;">Dependencia</th>	
							<th style="text-align: center;">Observacion adicional</th>	
							<th style="text-align: center;">Observacion salida</th>	
								
						</tr>
					</thead>
					<tbody>
						<?php 
						   $minutas=$model->Registros($row['cedula_persona'],$fecha_actual);
						   foreach($minutas as $mn):
						?>
						<tr>
						<td>	

							<?php if($mn['hora_salida']=='00:00:00') :?>
							
							<button class="btn btn-success btn-xs" data-target="#myModal-salida" data-toggle="modal" onclick="asignar(<?= $mn["id"] ?>)">
								<i class="fa fa-sign-out"></i> Salida
							</button>
							
							<?php endif;?>

							
						</td>
						<td style="text-align: center;">
							<?php echo $mn['hora_entrada'] ?> <b>/</b> <?php echo $mn['hora_salida'] ?>	
						</td>
						<td style="text-align: center;"><?php echo $mn['fecha'] ?></td>
						<td style="text-align: center;"><?php echo $mn['dependencia'] ?></td>
						<td style="text-align: center;"><?php echo $mn['observacion'] ?></td>
						<td style="text-align: center;"><?php echo $mn['observacion_salida'] ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			</td>
			
		</tr>
	<?php 
		$i++;
		endforeach; 
	?>
	<?php 

	if($i==0){

	?>
	<tr>
		<td style="text-align: center;" colspan="7"> 
           <i class="fa fa-user-times"></i>
           No existe registro de ingreso
        </td>
	</tr>
	<?php }?>

	</tbody>

</table>
</div>

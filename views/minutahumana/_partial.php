<?php 
	use yii\helpers\Url;
	
?>
<div class="table-responsive">
<table class="table table-striped">
	<thead>
		
		<tr>
			<th style="text-align: center;"></th>
			<th style="text-align: center;">Cedula</th>	
			<th style="text-align: center;">Persona</th>
			<th style="text-align: center;">Tipo Invitado</th>
			<th style="text-align: center;">Area</th>
			<th style="text-align: center;">Hora Entrada</th>	
			<th style="text-align: center;">Hora Salida</th>
			<th style="text-align: center;">Puesto</th>
			<th style="text-align: center;">Fecha</th>	
			<!-- <th style="text-align: center;">Empresa</th> -->
			<th style="text-align: center;">Dependencia</th>	
			<th style="text-align: center;">Usuario</th>
			<th style="text-align: center;">Observacion adicional</th>	
			<th style="text-align: center;">Observacion salida</th>	
				
		</tr>
	</thead>
	<tbody>
		<?php 
		$i=0;
		foreach($query as $row):
		?>
		<tr>
			<td>	

				<?php if($row['hora_salida']=='00:00:00') :?>
				
				<button class="btn btn-success btn-xs" data-target="#myModal-salida" data-toggle="modal" onclick="asignar(<?= $row["id"] ?>)">
					<i class="fa fa-check"></i> Salida
				</button>
				
				<?php endif;?>
			</td>
			<td style="text-align: center;"><?php echo $row['cedula_persona'] ?></td>
			<td style="text-align: center;"><?php echo $row['Persona'] ?></td>
			<td style="text-align: center;"><?php echo $row['tipo_invitado'] ?></td>
			<td style="text-align: center;"><?php echo $row['tipo_observacion'] ?></td>
			<td style="text-align: center;"><?php echo $row['hora_entrada'] ?></td>
			<td style="text-align: center;"><?php echo $row['hora_salida'] ?></td>
			<td style="text-align: center;"><?php echo $row['puesto'] ?></td>
			<td style="text-align: center;"><?php echo $row['fecha'] ?></td>
			<!-- <td style="text-align: center;"><?php //echo $row['empresa'] ?></td> -->
			<td style="text-align: center;"><?php echo $row['dependencia'] ?></td>
			<td style="text-align: center;"><?php echo $row['usuario'] ?></td>
			<td style="text-align: center;"><?php echo $row['observacion'] ?></td>
			<td style="text-align: center;"><?php echo $row['observacion_salida'] ?></td>
			
		</tr>
	<?php 
		$i++;
		endforeach; 
	?>
	<?php 

	if($i==0){

	?>
	<tr>
		<td style="text-align: center;" colspan="12"> 
           <i class="fa fa-user-times"></i>
           No existe registro de ingreso
        </td>
	</tr>
	<?php }?>

	</tbody>

</table>
</div>

<script type="text/javascript">
	function asignar(id){

		
		$('#form-salida').attr('action','<?php echo Url::toRoute('minutahumana/salida')?>'+"?id="+id);
	}
</script>
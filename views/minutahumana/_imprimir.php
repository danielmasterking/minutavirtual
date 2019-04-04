<?php 
	use yii\helpers\Url;
?>



<table style="border: none;" >
	<tr style="border: none;">
		<td style="border: none;"> <img src="<?php echo $logo_emp ?>" alt="..." class="thumbnail" style='height: 65px;width: 90px;'></td>
		<td style="border: none;"><h3>INGRESO Y SALIDA DE PERSONAS</h3></td>
	</tr>
</table>



<table class="table table-striped table-bordered">
	<thead>
		
		<tr>
			
			<th style="text-align: center;">Cedula</th>	
			<th style="text-align: center;">Persona</th>
			<th style="text-align: center;">Tipo Invitado</th>
			<th style="text-align: center;">Tipo Observacion</th>
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
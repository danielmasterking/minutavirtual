<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;

$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
	$permisos = Yii::$app->session['permisos-exito'];
}
?>
<table  class="table table-hover" width="100%">
	<thead>
		<tr>
			<!-- <th style="width: 12%;">Ciudad</th> -->
			<th style="width: 12%;">Dependencia</th>
			<?php 
				if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
				<th style="width: 25%;">Presupuestos</th>
			<?php } ?>
			<th style="width: 22%;">Saldo</th>
			<th style="width: 10%;">Pedidos</th>
			<th style="width: 10%;">Finalizacion</th>
			<th style="width: 23%;">Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($model as $key):?>
		<tr>
			<!-- <td><?php //echo $key['ciudad']?></td> -->
			<td><?= $key['dependencia']?></td>
			<?php 
				if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
			<td>
				<b>Total:</b><br>
				<?php echo '$'.number_format($key['presupuesto_total'], 0, '.', '.').' COP ';
				if($key['presupuesto_total']<$key['suma_total']){
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<br>
				<b>Seguridad:</b><br>
				<?php echo '$'.number_format($key['presupuesto_seguridad'], 0, '.', '.').' COP ';
				if($key['presupuesto_seguridad']<$key['suma_seguridad']){
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<br>
				<b>Riesgo:</b><br>
				<?php echo '$'.number_format($key['presupuesto_riesgo'], 0, '.', '.').' COP ';
				if($key['presupuesto_riesgo']<$key['suma_riesgo']){
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<!--
				<br>
				<b>Activo:</b><br>-->
				<?php /*echo '$'.number_format($key['presupuesto_activo'], 0, '.', '.').' COP ';
				if($key['presupuesto_activo']<$key['suma_activo']){
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<br>
				<b>Gasto:</b><br>
				<?php echo '$'.number_format($key['presupuesto_gasto'], 0, '.', '.').' COP ';
				if($key['presupuesto_gasto']<$key['suma_gasto']){
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }*/
				?>

			</td>
			<?php } ?>
			<td>
				<b>Total:</b><br>
				<?php
				$total_iva=round((($key['suma_total']*$key['iva'])/100)+$key['suma_total']);
				if(($key['presupuesto_total']-$total_iva)<0){
	                echo '<b style="color:red;">$'.number_format(($key['presupuesto_total']-$total_iva), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<b style="color:green;">$'.number_format(($key['presupuesto_total']-$total_iva), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<br>
				<b>Seguridad:</b><br>
				<?php
				$total_iva_seguridad=round((($key['suma_seguridad']*$key['iva'])/100)+$key['suma_seguridad']);
				if(($key['presupuesto_seguridad']-$total_iva_seguridad)<0){
	                echo '<b >$'.number_format(($key['presupuesto_seguridad']-$total_iva_seguridad), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money fa-2x" ></i>';
	            }else{
	                echo '<b >$'.number_format(($key['presupuesto_seguridad']-$total_iva_seguridad), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money" ></i>';
	            }
				?><br>
				<b>Riesgo:</b><br>
				<?php
				$total_iva_riesgo=round((($key['suma_riesgo']*$key['iva'])/100)+$key['suma_riesgo']);
				if(($key['presupuesto_riesgo']-$total_iva_riesgo)<0){
	                echo '<b >$'.number_format(($key['presupuesto_riesgo']-$total_iva_riesgo), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money fa-2x" ></i>';
	            }else{
	                echo '<b >$'.number_format(($key['presupuesto_riesgo']-$total_iva_riesgo), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money" ></i>';
	            }
				?>
				<!--
				<br>
				<b>Activo:</b><br>-->
				<?php /*
				if(($key['presupuesto_activo']-$key['suma_activo'])<0){
	                echo '<b style="color:red;">$'.number_format(($key['presupuesto_activo']-$key['suma_activo']), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<b style="color:green;">$'.number_format(($key['presupuesto_activo']-$key['suma_activo']), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }
				?>
				<br>
				<b>Gasto:</b><br>
				<?php
				if(($key['presupuesto_gasto']-$key['suma_gasto'])<0){
	                echo '<b style="color:red;">$'.number_format(($key['presupuesto_gasto']-$key['suma_gasto']), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
	            }else{
	                echo '<b style="color:green;">$'.number_format(($key['presupuesto_gasto']-$key['suma_gasto']), 0, '.', '.').' COP </b>';
	                echo '<i class="fa fa-money" style="color:green;"></i>';
	            }*/
				?>
			</td>
			<td>
			<b>Seguridad:</b><br><?= $key['count_normal_seguridad']+$key['count_especial_seguridad'];?><br>
			<b>Riesgo:</b><br><?= $key['count_normal_riesgo']+$key['count_especial_riesgo'];?><br>
			</td>
			<td>
			<?php 
			$date = new DateTime($key['fecha_finalizacion']);
			echo $date->format('Y-m-d');?></td>
			<td>
				<?php 
					if((in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)) /*&& $key['estado']=='ABIERTO'*/){?>
					<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/update?id='.$key['id'])?>">
						<i class="fa fa-usd"></i> Agregar Presupuesto
					</a>
				<?php } ?>
				<?php 
					if($key['estado']=='ABIERTO'){?>
					<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/pedidos-create?id='.$key['id'].'&ceco='.$key['ceco'])?>">
						<i class="fa fa-plus"></i> Pedir Normal
					</a>
					<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/pedidos-create-especial?id='.$key['id'].'&ceco='.$key['ceco'])?>">
						<i class="fa fa-plus"></i> Pedir Especial
					</a>
				<?php } ?>
				<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/view?id='.$key['id'])?>">
					<i class="fa fa-list"></i> Ver/Listar
				</a>
				<?php 
					if(in_array("administrador", $permisos)){?>
					<p></p>
					<a class="btn btn-danger" href="#" onclick="eliminar('<?=$key['id']?>');return false;">
						<i class="fa fa-trash"></i> Eliminar
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
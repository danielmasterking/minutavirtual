<?php
use yii\helpers\Url;
$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
	$permisos = Yii::$app->session['permisos-exito'];
}
?>

<!--MODAL-->
<button type="button" class="btn btn-primary lock" data-toggle="modal" data-target="#modal">
	Agregar Cotizacion
</button>



<?php 
	if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
<div class="btn-group dropup">
  	<button type="button" class="btn btn-primary btn-xs lock">Marcar Como...</button>
  	<button type="button" class="btn btn-primary btn-xs dropdown-toggle lock" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	<span class="caret"></span>
    	<span class="sr-only">Toggle Dropdown</span>
  	</button>
  	<ul class="dropdown-menu">
    	<li><a href="#" onclick="cambiarGastoActivoCheckBox('gasto','especial');return false;"><i class="fa fa-usd"></i> -Gasto</a></li>
    	<li><a href="#" onclick="cambiarGastoActivoCheckBox('activo','especial');return false;"><i class="fa fa-line-chart"></i> +Activo</a></li>
  	</ul>
</div>
<?php } ?>
<table class="table table-hover" width="100%">
	<thead>
		<tr>
			<th style="width: 5%;">
				<input type="checkbox" class="checkBoxAll"/>
			</th>
			<th style="width: 5%;">Area</th>
			<th style="width: 15%;">Material</th>
			<th style="width: 5%;">Cant</th>
			<?php 
				if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
					<th style="width: 20%;">Precio Neto</th>
			<?php } ?>
			<th style="width: 10%;">Cotizacion</th>
			<th style="width: 10%;">Solicita</th>
			<th style="width: 10%;">Fecha</th>
			<?php 
				if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos) || in_array("coordinador", $permisos)){?>
			<th style="width: 30%;">Acciones</th>
			<?php 	}?>
		</tr>
	</thead>
	<tbody>
	<?php foreach($model as $key):?>
		<tr>
			<td>
				<input name='det_id[]' type="checkbox" class="checkBoxid" id="<?=$key['id']?>" value='<?=$key['id']?>' />
			</td>
			<td><?= ucwords($key['tipo_presupuesto'].' - '.$key['gasto_activo'])?></td>
			<td>
			<?php
			  	if($key['repetido']=='SI'){
					echo '<label style="color: red;">R</label>';
			  	}
			?>
			<?= $key['material']?></td>
			<td><?= $key['cantidad']?></td>
			<?php 
				if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
					<td><?='$ '.number_format($key['precio_neto'], 0, '.', '.').' COP'?></td>
			<?php } ?>
			<td>
				<?php //if($presupuesto->archivo!=''){ ?>
					<!-- <a href="<?php //echo 'http://cvsc.com.co/sgs/web/'.$presupuesto->archivo;?>" download>
					 	<i class="fa fa-download" aria-hidden="true"></i>
					</a> -->
				<?php //}else{
						//echo '-';
					  //}
				?>

				 <button type="button" class="btn btn-primary btn-xs" onclick="cotizaciones(<?=$key['id']?>);" data-toggle="modal" data-target="#modal1"> 
				 	<i class="fa fa-file-archive-o" aria-hidden="true"></i>
				 	Cotizaciones
				 </button>
			</td>
			<td><?= $key['solicitante']?></td>
			<td><?= $key['fecha']?></td>
			<td>
			<?php if(in_array("coordinador", $permisos) || in_array("administrador", $permisos)){?>
				<?php 
						if($estado==1){?>
							<button type='button' class="btn btn-primary lock" data-toggle="modal" data-target="#modal-no-aprobado"  onclick="setDataNa(2,<?=$key['id']?>,'especial','<?=$key['cantidad']?>')"><i class="fa fa-thumbs-down"></i> No Aprobar</button>
				<?php 	}else if($estado==2){?>
							<button type='button' class="btn btn-primary lock" onclick="cambiarEstado(1,<?=$key['id']?>,'especial','<?=$key['cantidad']?>')"><i class="fa fa-thumbs-up"></i> Aprobar</button>
				<?php 	}
					
				?>
			<?php }?>
			<?php if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
				<div class="btn-group dropup">
				  	<button type="button" class="btn btn-primary btn-xs lock">Marcar Como...</button>
				  	<button type="button" class="btn btn-primary btn-xs dropdown-toggle lock" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    	<span class="caret"></span>
				    	<span class="sr-only">Toggle Dropdown</span>
				  	</button>
				  	<ul class="dropdown-menu">
				    	<li><a href="#" onclick="cambiarGastoActivo('gasto',<?=$key['id']?>,'especial');return false;"><i class="fa fa-usd"></i> -Gasto</a></li>
				    	<li><a href="#" onclick="cambiarGastoActivo('activo',<?=$key['id']?>,'especial');return false;"><i class="fa fa-line-chart"></i> +Activo</a></li>
				  	</ul>
				</div>
			<?php }	?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
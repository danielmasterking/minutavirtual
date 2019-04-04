<?php
use yii\helpers\Html;

$this->title = 'Configuracion de Dispositivo Fijo de  Seguridad Electronica';

///Desformatear un numero
function number_unformat($number, $force_number = true, $dec_point = ',', $thousands_sep = '.') {
	if ($force_number) {
		$number = preg_replace('/^[^\d]+/', '', $number);
	} else if (preg_match('/^[^\d]+/', $number)) {
		return false;
	}
	$type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
	$number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
	settype($number, $type);
	return $number;
}


///////////////////////

?>
<div class="row">
	<div class="col-md-12">
		<?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>
	</div>
</div>
<br>



<!-- <div class="row">
	<div class="col-md-12"> -->
<?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Pre-facturas',Yii::$app->request->baseUrl.'/centro-costo/prefacturas?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	<!-- </div>
</div> -->

<!-- <div class="row">
	<div class="col-md-12"> -->
<?= Html::a('<i class="glyphicon glyphicon-plus"></i> Nuevo Dispositivo Fijo',Yii::$app->request->baseUrl.'/centro-costo/createmodeloelectronica?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	<!-- </div>
</div> -->
<?= Html::a('<i class="glyphicon glyphicon-plus"></i> Nuevo  Monitoreo',Yii::$app->request->baseUrl.'/centro-costo/createmonitoreo?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>

<?php 

    $flashMessages = Yii::$app->session->getAllFlashes();

    if ($flashMessages) {
    	echo "<br><br><div class='row'>";
        foreach($flashMessages as $key => $message) {
            echo "<div class='alert alert-" . $key . " alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    $message
                </div>";   
        }

        echo "</div>";
    }
?>

<h1 style="text-align: center;">MONITOREO DE ALARMAS</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th></th>
			<th colspan="2">Valor Total</th>
			<th>Monitoreo</th>
			<th>Sistema Monitoreado</th>
			<th>Cantidad Servicios</th>
			<th>Valor Unitario</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
			<th></th>

		</tr>
	</thead>
	<tbody>
		<?php 
			$total_monitoreo=0;
			foreach($monitoreos as $row_monitoreo): 
		?>
			<tr>
				<td></td>
				<td colspan="2">
					<?php

						$total_monitoreo=$total_monitoreo+$row_monitoreo->valor_total;
						echo '$ '.number_format($row_monitoreo->valor_total, 0, '.', '.').' COP';
					?>
					
				</td>
				<td><?= $row_monitoreo->monitoreo?></td>
				<td><?= $row_monitoreo->sistemanonitoreado->nombre ?></td>
				<td><?= $row_monitoreo->cantidad_servicios?></td>
				<td><?= '$ '.number_format($row_monitoreo->valor_unitario, 0, '.', '.').' COP' ?></td>
				<td><?= $row_monitoreo->fecha_inicio?></td>
				<td><?= $row_monitoreo->fecha_fin?></td>
				<td>
			  	<?php
			    	echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/updatemonitoreo?id='.$codigo_dependencia."&id_monitoreo=".$row_monitoreo->id,['title'=>'Actualizar']);
			    	
					echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/deletedispositvoelct?id='.$row_monitoreo->id.'&dependencia='.$codigo_dependencia,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento','title'=>'Eliminar']);
			  	?>
			  	</td>
				

			</tr>
		<?php endforeach;?>
		<tfoot>
			<tr>
		  	<td><strong>TOTAL: </strong></td>		  
		  	<td colspan="2">
		  		<?php echo '$ '.number_format($total_monitoreo, 0, '.', '.').' COP'?>
		  		
		  	</td>				  
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	
		</tr>
		</tfoot>
	</tbody>
</table>

<br>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>




<div class="col-md-12">
<table class = "table table-striped">
  	<thead>
		<tr>
			<th ></th>
	   		<th colspan="2">$/Mes</th>	   
	   		<th >Tipo Alarma </th>
	   		<th >Estado</th>
	   		<th >Marca</th>
	   		<th >Descripcion</th>
	   		<th >Referencia</th>
	   		<th >Ubicacion</th>
	   		<th ># Zona Panel</th>
	   		<th >Meses Pactados</th>
	   		<th >Fecha inicio</th>
	   		<th >Fecha ultima reposicion</th>
	   		<th ></th>
		</tr>

  	</thead>
  	<tbody id = "lastRow">
     	<?php  
     	$total=0;
     	foreach($filas_modelo as $value):?>
		    <tr>
		    	<td></td>
			  	<td colspan="2">
			  		<?php //echo '$ '.number_format($value->valor_arrendamiento_mensual, 0, '.', '.').' COP'?>
			  		<?php echo '$ '.$value->valor_arrendamiento_mensual.' COP'?>
			  	</td>
			  	<td><?=$value->tipoalarma->nombre?></td>
			  	<td><?=$value->estado?></td>
			  	<td><?=$value->marcaalarma->nombre?></td>
			  	<td><?= $value->desc->descripcion  ?></td>
			  	<td><?= $value->referencia ?></td>
			  	<td><?=$value->areas->nombre?></td>
			  	<td><?=$value->zona_panel?></td>
			  	<td><?=$value->meses_pactados?></td>	
			  	<td><?=$value->fecha_inicio?></td>
			  	<td><?=$value->fecha_ultima_reposicion?></td>
			  	<td>
			  	<?php
			  		
			    	$total=$total+number_unformat($value->valor_arrendamiento_mensual);

			    	echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/updatemodeloelectronica?id='.$codigo_dependencia."&id_prefactura=".$value->id,['title'=>'Actualizar']);
			    	
					echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/deletedispositvoelct?id='.$value->id.'&dependencia='.$codigo_dependencia,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento','title'=>'Eliminar']);
			  	?>
			  	</td>
			</tr>
	 	<?php endforeach;?>
	    <tr>
		  	<td><strong>TOTAL: </strong></td>		  
		  	<td colspan="2">
		  		<?php echo '$ '.number_format($total, 0, '.', '.').' COP'?>
		  		
		  	</td>				  
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>	
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td><strong><?php //echo $total_ftes?></strong></td>
		  	<td></td>
		  	<td></td>
		</tr>
		
  	</tbody>
</table>

</div>
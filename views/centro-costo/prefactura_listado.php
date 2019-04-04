<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Visitas períodicas';
if( isset(Yii::$app->session['permisos-exito']) ){
  $permisos = Yii::$app->session['permisos-exito'];
}
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
?>
<div class="row">
	<div class="col-md-12">
	<?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4">
	<?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Pre-facturas',Yii::$app->request->baseUrl.'/centro-costo/prefacturas?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>
</div>
<br>
<h3 style="text-align: center;">Prefacturas de la Dependencia <?=$model->nombre?></h3>
<div class="row">
	<div class="col-md-12">
		<table  class="table" style="font-size: 18px;">
		   	<thead>
			   	<tr>
				   	<th></th>
				   	<th>Año</th>
		           	<th>Mes</th>
		           	<th>Total del Servicio</th>
			   	</tr>
		   	</thead>
		   	<tbody>
	          	<?php foreach($modelo as $prefactura):?>
              	<tr>			   
			   		<td>
				   		<?php

				   		    if($prefactura->estado!='abierto'){	               
						   		if(in_array("administrador", $permisos) ){
			                  		echo Html::a('<i class="fa fa-file-pdf-o"></i>',Yii::$app->request->baseUrl.'/prefactura-fija/imprimir?id='.$prefactura->id,['target'=>'_blank']);
						   		} 
						   	}
				   		?>
					</td>
                	<td><?= $prefactura->ano?></td>
     				<td>
     					<?=strtoupper ($meses[$prefactura->mes-1]);?>
     				</td>
     				<?php 
			    	//AQUI SE CALCULA EL VALOR TOTAL DE FTES Y EL VALOR TOTAL DEL SERVICIO
			    	$dispositivos = $model_dispositivo->find()->where('id_prefactura_fija='.$prefactura->id)->all();
			    	$total_servicio_fijo = 0;
			    	$total_servicio_variable = 0;
			    	foreach ($dispositivos as $value) {
			    		if($value->tipo=='fijo'){
			    			$total_servicio_fijo = $total_servicio_fijo + $value->valor_mes;
			    		}elseif($value->tipo=='variable'){
			    			if($value->tipo_servicio !='No Prestado'){
                               $total_servicio_variable = $total_servicio_variable + $value->valor_mes;
                            }else{
                               $total_servicio_variable = $total_servicio_variable - $value->valor_mes;
                            }
			    		}

			    	}

			    ?>
			    <td><?='$ '.number_format(($total_servicio_fijo+$total_servicio_variable), 0, '.', '.').' COP'?></td>
              	</tr>
        	 <?php endforeach; ?>	
		   	</tbody>
		</table>
	</div>
</div>
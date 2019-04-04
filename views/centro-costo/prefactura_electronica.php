<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Visitas períodicas';
if( isset(Yii::$app->session['permisos-exito']) ){
  $permisos = Yii::$app->session['permisos-exito'];
}

$suma=0;
foreach ($modelo as $value) {
	$valor_mes=$model->number_unformat($value->valor_arrendamiento_mensual);

	$suma=$suma+$valor_mes;
	
}


$electronica='active';
?>
<div class="row">
	<div class="col-md-12">
	<?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-12">
	<?= $this->render('_tabsprefactura',['codigo_dependencia' => $codigo_dependencia,'electronica' => $electronica]) ?>
	</div>
</div>
<br>



<div class="row">
	<div class="col-md-4">
	<?= Html::a('<i class="fa fa-cogs"></i> Configuracion de Dispositivo Fijo',Yii::$app->request->baseUrl.'/centro-costo/modeloelectronico?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>
	<div class="col-md-5">
		<?= Html::a('<i class="fa fa-cogs"></i> Configuracion de Monitoreo',Yii::$app->request->baseUrl.'/centro-costo/modeloelectronico?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>

	</div>
	<div class="col-md-3">
	<?= Html::a('<i class="fa fa-list-ol"></i> Listado de Prefacturas',Yii::$app->request->baseUrl.'/centro-costo/listado-prefacturas?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>
</div>
<br>
<h2 style="text-align: center;">Resumen Electronica</h2>
<div class="row">
	<div class="col-md-12">
		<table  class="table" style="font-size: 18px;">
		   	<thead>
			   	<tr>
				   	<th>Dispositivo</th>
			       	<th>Costo</th>
			       
			   	</tr>
		   	</thead>
		   	<tbody>
	          	<tr>
		            <td>Fijo</td>
		 			<td><?php echo '$ '.number_format($suma, 0, '.', '.').' COP'?></td>
		 			
	          	</tr>
		   	</tbody>
		</table>
	</div>
</div>
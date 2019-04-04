<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CentroCosto;
use kartik\widgets\Select2;
use kartik\date\DatePicker;

$ciudades_zonas = array();
$zonas_ids = array();
foreach($zonasUsuario as $zonaO){
    $ciudades_zonas [] = $zonaO->zona->ciudades;	
	$zonas_ids [] = $zonaO->zona->id;
}
$ciudades_permitidas = array();
foreach($ciudades_zonas as $ciudades){
	foreach($ciudades as $ciudad){
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
	}
}
$marcas_permitidas = array();
foreach($marcasUsuario as $marca){
	$marcas_permitidas [] = $marca->marca_id;
}
$dependencias_distritos = array();
foreach($distritosUsuario as $distrito){
    $dependencias_distritos [] = $distrito->distrito->dependencias;
}
$distritos_permitidos = array();
foreach($distritosUsuario as $distrito){
    $distritos_permitidos [] = $distrito->distrito->id;
}
$dependencias_permitidas = array();
foreach($dependencias_distritos as $dependencias0){
	foreach($dependencias0 as $dependencia0){
		$dependencias_permitidas [] = $dependencia0->dependencia->codigo;
	}
}
$tamano_dependencias_permitidas = count($dependencias_permitidas);
$data_dependencias = array();
foreach($dependencias as $value){
	if(in_array($value->ciudad_codigo_dane,$ciudades_permitidas)){
		if(in_array($value->marca_id,$marcas_permitidas)){
		   if($tamano_dependencias_permitidas > 0){
			   if(in_array($value->codigo,$dependencias_permitidas)){
				$data_dependencias[$value->codigo] =  $value->nombre;
			   }else{
				   //temporal mientras se asocian distritos
				   $data_dependencias[$value->codigo] =  $value->nombre;
			   }
		   }else{
			   $data_dependencias[$value->codigo] =  $value->nombre;
		   }
		}
	}
}
?>
<?php $form = ActiveForm::begin(['id'=>'form_create']); ?>

<?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

<?=
    $form->field($model, 'ceco')->widget(Select2::classname(), [
	    'data' => $data_dependencias,
	    'options' => ['placeholder' => 'Seleccionar Dependencia', ],
    ])
?>

<?= $form->field($model, 'orden_interna_gasto')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'orden_interna_activo')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'presupuesto_total')->textInput(['maxlength' => true, 'id' => 'presupuesto_total']) ?>

<?= $form->field($model, 'presupuesto_seguridad')->textInput(['maxlength' => true, 'id' => 'presupuesto_seguridad']) ?>

<?= $form->field($model, 'presupuesto_riesgo')->textInput(['maxlength' => true, 'id' => 'presupuesto_riesgo']) ?>

<?= $form->field($model, 'presupuesto_heas')->textInput(['maxlength' => true, 'id' => 'presupuesto_heas']) ?>

<?= $form->field($model, 'fecha_finalizacion')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Fecha Finalizacion ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
	    'todayHighlight' => true
    ]
]);
?>
<br>
<?php ActiveForm::end(); ?>
<button class="btn btn-primary btn-lg" onclick="validar();"><?= $model->isNewRecord ? 'Crear' : 'Actualizar'?></button>
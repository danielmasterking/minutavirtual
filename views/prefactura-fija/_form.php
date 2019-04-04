<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
date_default_timezone_set ('America/Bogota');
$year = date('Y');
$regionales = array();
$ciudades_zonas = array();//almacena las regionales permitidas al usuario

foreach($zonasUsuario as $zona){
	$ciudades_zonas [] = $zona->zona->ciudades;
}
$ciudades_permitidas = array();
$ciudades_zonas_permitidas = array();//guarda solo la regional y la ciudad para filtrar por javascript
foreach($ciudades_zonas as $ciudades){
	foreach($ciudades as $ciudad){
		foreach($zonas as $z){
			if($z->id==$ciudad->zona_id){
				$regionales[$z->nombre] = $z->nombre;break;
			}
		}
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		$ciudades_zonas_permitidas [] = array('zona' => $ciudad->zona_id, 'nombre' => $ciudad->ciudad->nombre, 'codigo' => $ciudad->ciudad->codigo_dane);
	}
}
$marcas_permitidas = array();
$marcas = array();
foreach($marcasUsuario as $marca){
	$marcas_permitidas [] = $marca->marca_id;
	$marcas[$marca->marca->nombre] = $marca->marca->nombre;
}
$empresas_permitidas = array();
$data_empresas = array();
foreach($empresasUsuario as $empresa){
	$empresas_permitidas [] = $empresa->nit;
	$data_empresas[$empresa->nit] = $empresa->empresa->nombre; 
}
$data_dependencias = array();
foreach($dependencias as $dependencia){
	if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ){
		if(in_array($dependencia->marca_id,$marcas_permitidas) ){
			if(in_array($dependencia->empresa,$empresas_permitidas) ){
				$data_dependencias[] = array('codigo' => $dependencia->codigo, 'nombre' => $dependencia->nombre, 'codigo_ciudad' => $dependencia->ciudad_codigo_dane, 'codigo_marca' => $dependencia->marca_id);
			}
		}
	}
}
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-4">
		<?= $form->field($model, 'mes')->dropDownList(['01' => 'ENERO', 
			'02' => 'FEBRERO',
			'03' => 'MARZO',
			'04' => 'ABRIL',
			'05' => 'MAYO',
			'06' => 'JUNIO',
			'07' => 'JULIO',
			'08' => 'AGOSTO',
			'09' => 'SEPTIEMBRE',
			'10' => 'OCTUBRE',
			'11' => 'NOVIEMBRE',
			'12' => 'DICIEMBRE',
		]) ?>
	</div>
	<div class="col-md-4">
		<?= $form->field($model, 'ano')->textInput(['value' => $year,'maxlength' => true,'readonly'  => 'readonly']) ?>
	</div>
	<div class="col-md-4">
		<?= $form->field($model, 'regional')->widget(Select2::classname(), [
			'data' => $regionales,
			'options' => ['placeholder' => 'Selecccione Regional'],
		])?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?= $form->field($model, 'empresa')->widget(Select2::classname(), [
			'data' => $data_empresas,
			'options' => ['placeholder' => 'Selecccione Empresa'],
		])?>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'ciudad')->widget(Select2::classname(), [
			'data' => null,
			'options' => ['placeholder' => 'Selecccione Ciudad'],
		])?>
	</div>
	<div class="col-md-6">
		<?= $form->field($model, 'marca')->widget(Select2::classname(), [
			'data' => $marcas,
			'options' => ['placeholder' => 'Selecccione Marca'],
		])?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?= $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
			'data' => null,
			'options' => ['placeholder' => 'Selecccione Dependencia'],
		])?>
	</div>
</div>
<?= Html::submitButton('Generar', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
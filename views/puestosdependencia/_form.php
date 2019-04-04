<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\PuestosDependencia */
/* @var $form yii\widgets\ActiveForm */
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
				$regionales[$z->id] = $z->nombre;break;
			}
		}
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		$ciudades_zonas_permitidas [] = array('zona' => $ciudad->zona_id, 'nombre' => $ciudad->ciudad->nombre, 'codigo' => $ciudad->ciudad->codigo_dane);
	}
}
// $marcas_permitidas = array();
// $marcas = array();
// foreach($marcasUsuario as $marca){
// 	$marcas_permitidas [] = $marca->marca_id;
// 	$marcas[$marca->marca->nombre] = $marca->marca->nombre;
// }
$empresas_permitidas = array();
foreach($empresasUsuario as $empresa){
	$empresas_permitidas [] = $empresa->nit;
}

$data_dependencias = array();
foreach($dependencias as $dependencia){
	if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ){
		//if(in_array($dependencia->marca_id,$marcas_permitidas) ){
			if(in_array($dependencia->empresa,$empresas_permitidas) ){
				//$data_dependencias[] = array('codigo' => $dependencia->codigo, 'nombre' => $dependencia->nombre, 'codigo_ciudad' => $dependencia->ciudad_codigo_dane);

				$data_dependencias[$dependencia->codigo]= $dependencia->nombre;
			}
		//}
	}
}

?>

<div class="puestos-dependencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'codigo_dep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo_dep')->widget(Select2::classname(), [
			'data' => $data_dependencias,
			'options' => ['placeholder' => 'Selecccione Dependencia'],
		])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

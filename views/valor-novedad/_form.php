<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ValorNovedad */
/* @var $form yii\widgets\ActiveForm */
$data_novedad = array();

foreach ($novedades as $value) {
    
    $data_novedad[$value->id] = $value->nombre;
}

$data_resultados = array();

foreach ($resultados as $value) {
    
    $data_resultados[$value->id] = $value->nombre;
}


?>

<div class="valor-novedad-form">

    <?php $form = ActiveForm::begin(); ?>

	
	<?=

       $form->field($model, 'novedad_categoria_visita_id')->widget(Select2::classname(), [
       
	   'data' => $data_novedad,
    
      ])


     ?>
	 
	 <?=

       $form->field($model, 'resultado_id')->widget(Select2::classname(), [
       
	   'data' => $data_resultados,
    
      ])


     ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

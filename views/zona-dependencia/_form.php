<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

$data_areas = array();
foreach ($areas as $value) {
    
    $data_areas[$value->id] = $value->nombre;
}

/* @var $this yii\web\View */
/* @var $model app\models\ZonaDependencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zona-dependencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	
		<?=

       $form->field($model, 'area_dependencia_id')->widget(Select2::classname(), [
       
	   'data' => $data_areas,
    
      ])


     ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

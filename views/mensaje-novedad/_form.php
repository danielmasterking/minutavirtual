<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MensajeNovedad */
/* @var $form yii\widgets\ActiveForm */
$data_valores = array();

foreach ($valores as $value) {
    
    $data_valores[$value->id] = $value->novedadCategoriaVisita->nombre.'-'.$value->resultado->nombre;
}
?>

<div class="mensaje-novedad-form">

    <?php $form = ActiveForm::begin(); ?>

	
	<?=

       $form->field($model, 'valor_novedad_id')->widget(Select2::classname(), [
       
	   'data' => $data_valores,
    
      ])


     ?>


    <?= $form->field($model, 'mensaje')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'criterio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

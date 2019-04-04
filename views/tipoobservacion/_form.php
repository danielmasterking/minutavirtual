<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TipoObservacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-observacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php 
      echo $form->field($model, 'nit_empresa')->widget(Select2::classname(), [
          'data' =>$list_empresas,
          'options' => ['placeholder' => 'Selecciona empresa']
      ])->label('Empresa');

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloPrefactura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modelo-prefactura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'puesto_id')->textInput() ?>

    <?= $form->field($model, 'detalle_servicio_id')->textInput() ?>

    <?= $form->field($model, 'cantidad_servicios')->textInput() ?>

    <?= $form->field($model, 'horas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lunes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'martes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'miercoles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jueves')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'viernes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sabado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domingo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'festivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hora_inicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hora_fin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'porcentaje')->textInput() ?>

    <?= $form->field($model, 'ftes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_dias')->textInput() ?>

    <?= $form->field($model, 'valor_mes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'centro_costo_codigo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

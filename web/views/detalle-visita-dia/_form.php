<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleVisitaDia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-visita-dia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visita_dia_id')->textInput() ?>

    <?= $form->field($model, 'novedad_categoria_visita_id')->textInput() ?>

    <?= $form->field($model, 'resultado_id')->textInput() ?>

    <?= $form->field($model, 'observacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mensaje_novedad_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

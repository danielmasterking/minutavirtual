<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GestionRiesgo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gestion-riesgo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_centro_costo')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

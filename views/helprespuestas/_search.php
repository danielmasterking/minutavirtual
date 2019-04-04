<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HelpRespuestasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-respuestas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_consulta') ?>

    <?= $form->field($model, 'cumple') ?>

    <?= $form->field($model, 'no_cumple') ?>

    <?= $form->field($model, 'en_proceso') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

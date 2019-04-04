<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HelpRespuestas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-respuestas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_consulta')->textInput() ?>

    <?= $form->field($model, 'cumple')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'no_cumple')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'en_proceso')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

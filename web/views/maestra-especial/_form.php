<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MaestraEspecial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maestra-especial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'texto_breve')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'precio')->textInput() ?>
	<?= $form->field($model, 'imputacion')->textInput(['maxlength' => true]) ?>
	 



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

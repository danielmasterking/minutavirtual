<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleMaestra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-maestra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proveedor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'texto_breve')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_compras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'posicion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organizacion_compras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grupo_de_compras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio_neto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'moneda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidad_medida')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor_previsto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imputacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distribucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'indicador_iva')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo_activo_fijo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maestra_proveedor_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

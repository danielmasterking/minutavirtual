<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id'=>'form_update']); ?>

<?= $form->field($model, 'presupuesto_seguridad')->textInput(['maxlength' => true, 'id' => 'presupuesto_seguridad', 'value' => '']) ?>

<?= $form->field($model, 'presupuesto_riesgo')->textInput(['maxlength' => true, 'id' => 'presupuesto_riesgo', 'value' => '']) ?>

<?= $form->field($model, 'presupuesto_heas')->textInput(['maxlength' => true, 'id' => 'presupuesto_heas', 'value' => '']) ?>
<br>
<?php ActiveForm::end(); ?>
<button class="btn btn-primary btn-lg" onclick="validar();"><?= $model->isNewRecord ? 'Crear' : 'Agregar'?></button>
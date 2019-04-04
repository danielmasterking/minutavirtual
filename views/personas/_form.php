<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'cedula')->textInput() ?>    
        </div>
        
    </div>


    <div class="row">
        
        <div class="col-md-6">
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
        </div>
    
        <div class="col-md-6">
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php //echo $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <!-- <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Femenino', ], ['prompt' => '']) ?>
        </div>

        <div class="col-md-6">
           <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->

   <!--  <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->field($model, 'estado')->dropDownList([ 'A' => 'Activo', 'I' => 'Inactivo', ], ['prompt' => '']) ?>
        </div>
    </div>

    <?php //echo $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

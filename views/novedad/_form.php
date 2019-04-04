<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Novedad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="novedad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'tipo')->dropDownList(['C' => 'Capacitación',
	                                                'D' => 'Comite',
													'E' => 'Eventos',
													'S' => 'Siniestro',
													'I' => 'Incidente']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

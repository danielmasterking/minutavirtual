<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Macroactividad */
/* @var $form yii\widgets\ActiveForm */
$data_metricas = array();

foreach ($metricas as $key) {
  
  $data_metricas[$key->id] = $key->nombre; 
}
?>

<div class="macroactividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'peso')->textInput() ?>
	
		<?= $form->field($model, 'metrica_id')->widget(Select2::classname(), [
       
	   'data' => $data_metricas,
    
      ])?>		

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Novedad */
/* @var $form yii\widgets\ActiveForm */

$data_indicadores = array();

foreach ($indicadores as $key) {
  
  $data_indicadores[$key->id] = $key->nombre; 
}

$data_periodicidad = array();

foreach ($periodicidades as $key) {
  
  $data_periodicidad[$key->id] = $key->nombre; 
}



?>

<div class="novedad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'peso')->textInput() ?>
	
		<?= $form->field($model, 'indicador_id')->widget(Select2::classname(), [
       
	   'data' => $data_indicadores,
    
      ])?>	
	  
	  <?= $form->field($model, 'periodicidad_id')->widget(Select2::classname(), [
       
	   'data' => $data_periodicidad,
    
      ])?>	
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

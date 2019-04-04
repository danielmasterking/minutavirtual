<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Distrito */
/* @var $form yii\widgets\ActiveForm */

$data_zonas = array();

foreach($zonas as $zona){
	
	$data_zonas[$zona->id] = $zona->nombre; 
	
}

?>

<div class="distrito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	
		<?php
		
		   echo Select2::widget([
			'name' => 'regional',
			'data' => $data_zonas,
			'options' => [
				'id' => 'regional',
				'placeholder' => 'Regional',
											
			 ],


		   ]);
		
	?>	
	<p>&nbsp;</p>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

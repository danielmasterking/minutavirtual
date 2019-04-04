<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Macroactividad */
/* @var $form yii\widgets\ActiveForm */
$data_macroactividades = array();

foreach ($microactividades as $key) {
  
  $data_microactividades[$key->id] = $key->nombre; 
}

$data_novedades = array();

foreach ($novedades as $key) {
  
  $data_novedades[$key->id] = $key->nombre; 
}


?>

<div class="macroactividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
	
		<?= $form->field($model, 'microactividad_id')->widget(Select2::classname(), [
       
	   'data' => $data_microactividades,
    
      ])?>	

    <input type="checkbox" name="novedad" id="novedad" /> Novedad
<p>&nbsp;</p>	
	<div class="form-group">
	
		<?php
		
			echo Select2::widget([
				'name' => 'novedades',
				'data' => $data_novedades,
				
			]);
		
		?>
		

	
	</div>
	
	<div class="form-group">
	
	  	<label>Operación</label>
		
		<select class="form-control" name="operacion" id="operacion">
		  
		  <option>Contar</option>
		  <option>Sumar</option>
		  <option></option>
		  
		  
		</select>
	
	</div>
	
	
	<div class="form-group">
	
	  	<label >Cantidad Total</label>
		<input type="text" class="form-control" name="cantidad" id="cantidad" />
	
	</div>
    <p>&nbsp;</p>	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\MaestraProveedor */
/* @var $form yii\widgets\ActiveForm */

$data_proveedor = array();

foreach ($proveedores as $key) {
  
  $data_proveedor[$key->id] = $key->nombre; 
}


$data_zonas = array();

foreach ($zonas as $key) {
  
  $data_zonas[$key->id] = $key->nombre; 
}


$data_marca = array();

foreach ($marcas as $key) {
  
  $data_marca[$key->id] = $key->nombre; 
}


?>

<div class="maestra-proveedor-form">

     <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>
	
  <?php if(!isset($actualizar)): ?>	
  
  
	<?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
       
	   'data' => $data_proveedor,
    
    ])?>

	<?= $form->field($model, 'marca_id')->widget(Select2::classname(), [
       
	   'data' => $data_marca,
    
    ])?>	
	
	
	
	
	<?php endif;?>
	
	<?= $form->field($model, 'zona_id')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	   //'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	<?= $form->field($model, 'zona_id_2')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	   'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>

	<?= $form->field($model, 'zona_id_3')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	   'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	

	<?= $form->field($model, 'zona_id_4')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	   'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>

	<?= $form->field($model, 'zona_id_5')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	

	<?= $form->field($model, 'zona_id_6')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	<?= $form->field($model, 'zona_id_7')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	<?= $form->field($model, 'zona_id_8')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	<?= $form->field($model, 'zona_id_9')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	<?= $form->field($model, 'zona_id_10')->widget(Select2::classname(), [
       
	   'data' => $data_zonas,
	    'options' => ['placeholder' => 'Regional Auxiliar'],
    
    ])?>	
	
	
	
	<label>Fecha de documento</label>
	
	<?php
	
			echo DateControl::widget([
			'name'=>'fecha_documento', 
			'type'=>DateControl::FORMAT_DATE,
		    'autoWidget'=>true,
		    'displayFormat' => 'php:Y-m-d',
		    'saveFormat' => 'php:Y-m-d',

		]);
	
	
	?>
	
	<p>&nbsp;</p>
	
	
	<div class="col-md-12">
	
		<div class="col-md-6">
		
		    <label>Fecha de inicio maestra</label>
	
			<?php
			
					echo DateControl::widget([
					'name'=>'fecha_inicio_periodo', 
					'type'=>DateControl::FORMAT_DATE,
					'autoWidget'=>true,
					'displayFormat' => 'php:Y-m-d',
					'saveFormat' => 'php:Y-m-d',

				]);
			
			
			?>
	
	
		</div>
		
		<div class="col-md-6">
		
		    <label>Fecha de finalización maestra</label>
	
			<?php
			
					echo DateControl::widget([
					'name'=>'fecha_final_periodo', 
					'type'=>DateControl::FORMAT_DATE,
					'autoWidget'=>true,
					'displayFormat' => 'php:Y-m-d',
					'saveFormat' => 'php:Y-m-d',

				]);
			
			
			?>
	
	
		</div>
	
	</div>

	<p>&nbsp;</p>
	
		<div class="col-md-12">
	
		<div class="col-md-6">
		
		    <label>Valor Total Maestra</label>
			<input type="text" class="form-control" name="valor-total-maestra" value="0"/>

	
	
		</div>
		
		<div class="col-md-6">
		
		    <label>Valor pendiente por gastar</label>
			<input type="text" class="form-control" name="valor-pendiente-gastar" value="0"/>
	

	
	
		</div>
	
	</div>
	
	<p>&nbsp;</p>
	
	
	<?php
	   
	  echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
			'pluginOptions'=>['allowedFileExtensions'=>['xls', 'xlsx'],
							   'maxFileSize' => 5120,
			 ]
      ]);
		
	?>

    <div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

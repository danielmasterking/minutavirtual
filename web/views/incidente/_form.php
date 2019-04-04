<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop ;
use yii\helpers\Url;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
date_default_timezone_set ( 'America/Bogota');
/* @var $this yii\web\View */
/* @var $model app\models\Siniestro */
/* @var $form yii\widgets\ActiveForm */
$data_novedades = array();

$fecha = date('Y-m-d',time());


foreach($novedades as $novedad){
	
   $data_novedades[$novedad->id] = $novedad->nombre;	
	
}


$ciudades_zonas = array();

foreach($zonasUsuario as $zonaO){
	
     $ciudades_zonas [] = $zonaO->zona->ciudades;	
	
}

$ciudades_permitidas = array();

foreach($ciudades_zonas as $ciudades){
	
	foreach($ciudades as $ciudad){
		
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		
	}
	
}

$marcas_permitidas = array();

foreach($marcasUsuario as $marca){
	
		
		$marcas_permitidas [] = $marca->marca_id;

}

$dependencias_distritos = array();

foreach($distritosUsuario as $distrito){
	
     $dependencias_distritos [] = $distrito->distrito->dependencias;	
	
}

$dependencias_permitidas = array();

foreach($dependencias_distritos as $dependencias0){
	
	foreach($dependencias0 as $dependencia0){
		
		$dependencias_permitidas [] = $dependencia0->dependencia->codigo;
		
	}
	
}

$tamano_dependencias_permitidas = count($dependencias_permitidas);

$data_dependencias = array();

foreach($dependencias as $value){
	
	if(in_array($value->ciudad_codigo_dane,$ciudades_permitidas)){
		
		if(in_array($value->marca_id,$marcas_permitidas)){
			
		   if($tamano_dependencias_permitidas > 0){
			   
			   if(in_array($value->codigo,$dependencias_permitidas)){
				   
				 $data_dependencias[$value->codigo] =  $value->nombre;
				   
			   }else{
				   //temporal mientras se asocian distritos
				   $data_dependencias[$value->codigo] =  $value->nombre;
			   }
			   
			   
		   }else{
			   
			   $data_dependencias[$value->codigo] =  $value->nombre;
		   }	
       
		}

	}
}


?>


<div class="siniestro-form">

      <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

	
   <div class="col-md-12">
   
       <div class="col-md-8">
	   
	   	 <?=

		   $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
		   
		   'data' => $data_dependencias,
		
		  ])


		 ?>
	   
	   </div>
	   
	   <div class="col-md-4">
	   
           <?= $form->field($model, 'fecha')->widget(DateControl::classname(), [
				  'autoWidget'=>true,
				 'displayFormat' => 'php:Y-m-d',
				 'saveFormat' => 'php:Y-m-d',
				  'type'=>DateControl::FORMAT_DATE,
     
           ]);?>
	   
	   </div>

   </div>   
    
	<div class="col-md-12">
	  <div class="col-md-12">
	<?=

       $form->field($model, 'novedad_id')->widget(Select2::classname(), [
       
	   'data' => $data_novedades,
    
      ])


     ?>
	 </div>   
	 </div>   

 
	 
	   <div class="col-md-12">
		  <div class="col-md-6">
		
		<?= $form->field($model, 'detalle')->widget(Summernote::className(), [
		
			'clientOptions' => [
				
	             //  'height' => 55,

				]		
		  
		]) ?>   
		
		 </div>
		 
		 <div class="col-md-6">
		
			 <?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'image2')->widget(FileInput::classname(), [
			'options'=>['accept'=>'image/*', 'multiple'=>true],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
							   'maxFileSize' => 5120,
			  ]
			 ]);

			 ?>
		
		 </div>
		 
	   </div>	
	   
	   <div class="col-md-12">
		  <div class="col-md-12">
		
		<?= $form->field($model, 'recomendaciones')->widget(Summernote::className(), [
		
			'clientOptions' => [
				
	               'height' => 55,

				]		
		  
		]) ?>   
		
		 </div>
	   </div>	


	   <div class="col-md-12">
		  <div class="col-md-12">
           
			 <?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'image[]')->widget(FileInput::classname(), [
			'options'=>['multiple'=>true],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg','docx','xlsx','pdf'],
							   'maxFileSize' => 5120,
			  ]
			 ]);

			 ?>
			
			<?= Html::activeHiddenInput($model, 'usuario',['value' => Yii::$app->session['usuario-exito'] ])?>
 		
                 <div class="form-group">
                   <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
                 </div>
		</div>
	   </div>   


    <?php ActiveForm::end(); ?>

</div>

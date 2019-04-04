<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\TimePicker;
use yii\web\JsExpression;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop ;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());
$data_dependencias = array();
$ciudades_zonas = array();

foreach($zonasUsuario as $zona){
	
     $ciudades_zonas [] = $zona->zona->ciudades;	
	
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

<div class="visita-mensual-form">

     <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

	<div class="col-md-12">
	  <div class="col-md-12">
	   <?= $form->field($model, 'fecha')->textInput(['value' => $fecha,'readonly' => 'readonly']) ?>
	   </div>
	</div>

	 <div class="col-md-12">

	    <div class="col-md-12">
		
           <?= $form->field($model, 'fecha_visita')->widget(DateControl::classname(), [
				 
            	 'autoWidget'=>true,
				  'displayFormat' => 'php:Y-m-d',
				  'saveFormat' => 'php:Y-m-d',
				  'type'=> DateControl::FORMAT_DATE,
     
           ]);?>
		
		</div>	

	</div>	
	
	<div class="col-md-12">
	  <div class="col-md-12">
	  	<?=

       $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
       
	   'data' => $data_dependencias,
		'options' => [
		'id' => 'dependencia',
		'placeholder' => 'Dependencia',
									
	    ],
    
      ])


     ?>
	   
	   </div>
	</div>
	
	<div class="col-md-12">
	  <div class="col-md-6">
	  
	     <?php

                // Child # 1
          echo $form->field($model, 'atendio')->widget(DepDrop::classname(), [
              'type'=>DepDrop::TYPE_SELECT2,
               'data' => [1 => ''],   
              'pluginOptions'=>[
              
                  'depends'=>['dependencia'],
                  'placeholder' => 'Select...',
                  'url'=>Url::to(['responsable/dependencia']),
                  //'params'=>['input-type-1', 'input-type-2']
              ]
          ]);


        ?>

        
	   
	   </div>
	   <div class="col-md-6">
     <?= $form->field($model, 'otro')->textInput(['maxlength' => true,'readonly' => 'readonly']) ?>
	   
	   </div>
	</div>	

    <?= Html::activeHiddenInput($model, 'usuario',['value' => Yii::$app->session['usuario-exito'] ])?>		

     <div class="col-md-12">
		  <div class="col-md-12">
		
		<?= $form->field($model, 'detalle')->widget(Summernote::className(), [
		
			'clientOptions' => [
				
	               'height' => 120,

				]
		  
		]) ?>   
		
		 </div>
	  </div>	
	  
	  <div class="col-md-12">
		  <div class="col-md-12">
		
		<?= $form->field($model, 'recomendaciones')->widget(Summernote::className(), [
		
			'clientOptions' => [
				
	               'height' => 120,

				]
		  
		]) ?>   
		
		 </div>
	  </div>	

	   <div class="col-md-12">
		  <div class="col-md-12">
           
			 <?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'file[]')->widget(FileInput::classname(), [
			'options'=>['multiple'=>true],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg','doc','docx','xls','xlsx','ppt','pptx','pdf'],
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

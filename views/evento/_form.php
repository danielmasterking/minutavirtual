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

$data_novedades = array();
foreach ($novedades as $value) {
    
    $data_novedades[$value->id] = $value->nombre;
}


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
$data_marcas = array();

foreach($marcasUsuario as $marca){
	
		
		$marcas_permitidas [] = $marca->marca_id;
		$data_marcas[$marca->marca_id] = $marca->marca->nombre; 

}

$dependencias_distritos = array();
$data_distritos = array();
foreach($distritosUsuario as $distrito){
	
     $dependencias_distritos [] = $distrito->distrito->dependencias;	
	 $data_distritos [$distrito->distrito_id] = $distrito->distrito->nombre; 
	
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

<div class="visita-dia-form">

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
	  
	  	<?=

       $form->field($model, 'novedad_id')->widget(Select2::classname(), [
       
	   'data' => $data_novedades,
    
      ])

     ?>
	  
	  
	  <div class="col-md-6">
	  
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
	  
	  <div class="col-md-3">
	     
	    
		  <?= $form->field($model, 'cantidad_apoyo')->textInput() ?>
	  
	  </div>
	  
	  	  <div class="col-md-3">
	     
	    
		  
	  
	      </div>
	  

	   
	   </div>
	</div>

    <div class="col-md-12">

	   <div class="col-md-12">
	   
	   	  <div class="col-md-6">
	       
		   <label><input type="checkbox" id="otros-chk" /> Otros</label>
		   <?= $form->field($model, 'otros')->textInput(['readonly' => 'readonly']) ?>
		  
		  </div>
		  
		  <div class="col-md-3">
		      <label>Cantidad de apoyo</label>
			 <?= $form->field($model, 'cantidad_apoyo_otros')->textInput(['readonly' => 'readonly']) ?>
		  
		  </div>
		  
		  	  	  <div class="col-md-3">
	     
	    
		  
	  
	      </div>
	  
	   
	   </div>
	   
	   

	</div>
	
	<!--<div class="col-md-12">
	   
	     <div class="col-md-12">
		   
		   <div class="form-group"> 
		   
		   <label><strong>Detalle del evento:</strong></label>
		   
		   </div>
		  
		   
		   <div class="col-md-6">
		      
			  <label><input type="checkbox" id="marca-chk" checked="checked"/> Marca</label>
			  
			  <div id="div-marca" class="show">
			  
			  			 
				 <?php

				   /*Select2::widget([
				   'name' => 'marca_select',
				   'data' => $data_marcas,
					'options' => [
					'id' => 'marca_select',
					'placeholder' => 'Marca',
					
												
					],
				
				  ])*/


				 ?>
			  
			  </div>

			 
		   
		   </div>
		   <div class="col-md-6">
		       <label><input type="checkbox" id="distrito-chk" checked="checked"/> Distrito</label>
			  
			  <div id="div-distrito" class="show">
			  <?php
			  /*
			   Select2::widget([
			   'name' => 'distrito_select',
			   'data' => $data_distritos,
				'options' => [
				'id' => 'distrito_select',
				'placeholder' => 'Distrito',
				'class' => 'hidden',
											
				],
			
			  ])*/


			 ?>
			 
			 </div>
		   </div>
		   
	     </div>   
		
	</div>-->
	
	<p>&nbsp;</p>
	
	 <div class="col-md-12">
		  <div class="col-md-12">
		
		<?= $form->field($model, 'descripcion')->widget(Summernote::className(), [
		
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
			 echo $form->field($model, 'image[]')->widget(FileInput::classname(), [
			'options'=>['accept'=>'image/*', 'multiple'=>true],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
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

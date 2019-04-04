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

$fecha = date('Y-m-d',time());



foreach($areas as $area){
	
   $data_areas[$area->id] = $area->nombre;	
	
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
				   
				 $data_dependencias [] = array('codigo' => $value->codigo, 'nombre' => $value->nombre);	  
				   
			   }else{
				   
				   	//temporal mientras se asocian distritos
				   $data_dependencias [] = array('codigo' => $value->codigo, 'nombre' => $value->nombre);	  
				   
			   }
			   
			   
		   }else{
			   
			   $data_dependencias [] = array('codigo' => $value->codigo, 'nombre' => $value->nombre);			
		   }	
       
		}

	}
}



$data_areas = array();
foreach ($areas as $value) {
    
    $data_areas[$value->id] = $value->nombre;
}

$data_areas_copia = array();
foreach ($areas as $value) {
    
    $data_areas_copia [] = array('codigo' => $value->id, 'nombre' => $value->nombre);;
}





?>
<script>

    var dependencias = <?php echo json_encode($data_dependencias);?>;
	var areas = <?php echo json_encode($data_areas_copia);?>;
	var len = dependencias.length;
	var len_areas = areas.length;
	var index_merma = 1;
	var index_area = 1;
	var index_material = 1;
	var total_recuperado = 0;

</script>

<div class="siniestro-form">

      <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

	
   <div class="col-md-12">
   

	   <div class="col-md-12">
	   
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
		   
		   <div id="dependencias" class="form-group">
		   
		   </div>	
         	   
			 
		 </div>		 
	   </div>
	  <!-- <p>&nbsp;</p> -->
    
	<div class="col-md-12">
	
	         <div class="col-md-12">
		    	<p>&nbsp;</p>
				 <!-- <button type="button" id="btn-add-area" class="btn btn-default btn-primary pull-right" aria-label="Left Align">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"> Sección</span>
				</button>-->
			  </div>
		   
		   <div id="areas" class="form-group">
		   
		   </div>	
  
	 </div>   
	 <p>&nbsp;</p>
	 <div class="col-md-12">
	    <div class="col-md-6">
		
		 <?=


		   $form->field($model, 'area_dependencia_id')->widget(Select2::classname(), [
            'options' => ['id' => 'area', 'placeholder' => 'Seleccione area'],
			'data' => $data_areas,
			
		
		  ])


		 ?>		
		
		</div>
		<div class="col-md-6">
			 <?=


			   $form->field($model, 'zona_dependencia_id')->widget(DepDrop::classname(), [
                'options' => ['id' => 'zona'],
                'type'=>DepDrop::TYPE_SELECT2,
                 //'data' => [1 => ''],   
                'pluginOptions'=>[
                
                    'depends'=>['area'],
                    'url'=>Url::to(['zona-dependencia/listado']),
                    //'params'=>['input-type-1', 'input-type-2']
                ]
			  ])

			 ?>
				
		</div>
	 </div>
	 

	 
	   <div class="col-md-12">
	     <div class="col-md-12">
		 
		   <div id="mermas" class="form-group">
		   
		   </div>
		   
         <div class="col-md-12">
		    	<p>&nbsp;</p>
				  <button type="button" id="btn-add-mat-mer" class="btn btn-default btn-primary pull-right" aria-label="Left Align">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"> Producto</span>
				</button>
		 </div>			   
		 
		 </div>
	   </div>
	   
	   	<div class="col-md-12">
		<div class="col-md-12">
             <div class="form-group">
			    <label>Total recuperado: </label>
				
				<input value="0" class="form-control col-md-6" type="text" id="total"/>
			 </div>	
             
           </div>				 
		 </div> 
      <p>&nbsp;</p>		 
	   
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
			'options'=>['accept'=>'image/*', 'multiple'=>true],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
							   'maxFileSize' => 5120,
			  ]
			 ]);

			 ?>
			<input type="hidden" name="cantidad-dep" id="cantidad-dep" value="0"/>		
			<input type="hidden" name="cantidad-mat" id="cantidad-mat" value="0"/>		
			<?= Html::activeHiddenInput($model, 'usuario',['value' => Yii::$app->session['usuario-exito'] ])?>
 		
                 <div class="form-group">
                   <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
                 </div>
		</div>
	   </div>   


    <?php ActiveForm::end(); ?>

</div>

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
$orden = 0;
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


$data_secciones = array();
foreach($secciones as $seccion){
	
	$data_secciones[$seccion->id] = $seccion->nombre;
	
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
          echo $form->field($model, 'responsable')->widget(DepDrop::classname(), [
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
	
    <div class="col-md-12">
	  <div class="col-md-12">
	    

		<?php foreach($categorias as $categoria):?>
		
			<div class="row">
			   
				  <div class="col-md-12">
				  <p>&nbsp;</p>
				   <p><strong><h3> <?= $categoria->nombre?></h3></strong></p>
				  
				  </div>
				  
				 			   
			 </div>
		
		   <?php 
		   
		      //obtener Novedades categoría
			  $novedades = $categoria->novedades;
			  
			  foreach($novedades as $novedad):
			  
			    $valores = $novedad->valorNovedades;
				$orden++;
				$data_valor =  array();

                foreach($valores as $valor){
					
					$data_valor[$valor->id] = $valor->resultado->nombre;
					
				}				
			  
			  if($novedad->id === 10){
				  
			  ?>
			  
			  <div class="row">
			  
			     <div class="col-md-4">
				   <p>&nbsp;</p>
				  
				   <p><strong><?= $orden?></strong><?= '. '.$novedad->nombre?></p>
				  
				  </div>
				  
				  <div class="col-md-3">
				   <p>&nbsp;</p>

				  </div>
				  
				  <div class="col-md-3">
				   	<p>&nbsp;</p>

				  </div>
				  
				  <div class="col-md-2">
				  <p>&nbsp;</p>
				     
				  </div>
			  
			  </div>
			 
			 <div class="row" >
			   
				  <div class="col-md-4">
				   <p>&nbsp;</p>
				  
				   <div class="row">
				   
				       <div class="col-md-4">
					   
					   <p><strong>a.</strong> Sección</p>
					   
					   </div>
					   
				   
				       <div class="col-md-8">
					   
							<?php
							
						        $mensajes = $valores[0]->mensajeNovedades;				   
					            $id_data = ($mensajes != null ) ? $mensajes[0]->id : 1;
					            $value_data = ($mensajes != null ) ? $mensajes[0]->mensaje : '';
							
							   echo Select2::widget([
								'name' => 'seccion-a',
								'data' => $data_secciones,
								'options' => [
									'id' => 'seccion-a',
									//'placeholder' => 'Sección',
																
								 ],


							   ]);
							
							?>						   
					   
					   </div>					   
				   
				   </div>				   
				  
				  </div>
				  
				  <div class="col-md-3">
				   <p>&nbsp;</p>
				    <?php
					
					   echo Select2::widget([
						'name' => 'valor-seccion-a',
						'data' => $data_valor,
						'options' => [
							'id' => 'valor-seccion-a',
							//'placeholder' => 'Estado',
														
						 ],


					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-3">
				   	<p>&nbsp;</p>
					<?php
					
					   echo DepDrop::widget([
					    'name' => 'mensaje-seccion-a',
						'options' => ['id' => 'mensaje-seccion-a'],
						'type'=>DepDrop::TYPE_SELECT2,
						 'data' => [$id_data => $value_data],   
						'pluginOptions'=>[
						
							'depends'=>['valor-seccion-a'],
							//'placeholder' => 'Select...',
							'url'=>Url::to(['mensaje-novedad/mensaje']),
							//'params'=>['input-type-1', 'input-type-2']
						]
						
					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-2">
				  <p>&nbsp;</p>
				      <input type="text" class="form-control" name="txt-seccion-a" placeholder="Comentario"/> 
				  </div>
			   
			   
			   </div>	
			   
 			 <div class="row" >
			   
				  <div class="col-md-4">
				   <p>&nbsp;</p>
				   
				   <div class="row">
				   
				       <div class="col-md-4">
					   
					   <p><strong>b.</strong> Sección</p>
					   
					   </div>
					   
				   
				       <div class="col-md-8">
					   
							<?php
							
							   echo Select2::widget([
								'name' => 'seccion-b',
								'data' => $data_secciones,
								'options' => [
									'id' => 'seccion-b',
									//'placeholder' => 'Sección',
																
								 ],


							   ]);
							
							?>						   
					   
					   </div>					   
				   
				   </div>
				  
				   
				  
				  </div>
				  
				  <div class="col-md-3">
				   <p>&nbsp;</p>
				    <?php
					
					   echo Select2::widget([
						'name' => 'valor-seccion-b',
						'data' => $data_valor,
						'options' => [
							'id' => 'valor-seccion-b',
							//'placeholder' => 'Estado',
														
						 ],


					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-3">
				   	<p>&nbsp;</p>
					<?php
					
					   echo DepDrop::widget([
					    'name' => 'mensaje-seccion-b',
						'options' => ['id' => 'mensaje-seccion-b'],
						'type'=>DepDrop::TYPE_SELECT2,
						 'data' => [$id_data => $value_data],
						'pluginOptions'=>[
						
							'depends'=>['valor-seccion-b'],
							//'placeholder' => 'Select...',
							'url'=>Url::to(['mensaje-novedad/mensaje']),
							//'params'=>['input-type-1', 'input-type-2']
						]
						
					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-2">
				  <p>&nbsp;</p>
				      <input type="text" class="form-control" name="txt-seccion-b" placeholder="Comentario"/> 
				  </div>
			   
			   
			   </div>	

			 <div class="row" >
			   
				  <div class="col-md-4">
				   <p>&nbsp;</p>
				  
				   <div class="row">
				   
				       <div class="col-md-4">
					   
					   <p><strong>c.</strong> Sección</p>
					   
					   </div>
					   
				   
				       <div class="col-md-8">
					   
							<?php
							
							   echo Select2::widget([
								'name' => 'seccion-c',
								'data' => $data_secciones,
								'options' => [
									'id' => 'seccion-c',
									//'placeholder' => 'Sección',
																
								 ],


							   ]);
							
							?>						   
					   
					   </div>					   
				   
				   </div>
				  
				  </div>
				  
				  <div class="col-md-3">
				   <p>&nbsp;</p>
				    <?php
					
					
					   echo Select2::widget([
						'name' => 'valor-seccion-c',
						'data' => $data_valor,
						'options' => [
							'id' => 'valor-seccion-c',
							//'placeholder' => 'Estado',
														
						 ],


					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-3">
				   	<p>&nbsp;</p>
					<?php
					
					   echo DepDrop::widget([
					    'name' => 'mensaje-seccion-c',
						'options' => ['id' => 'mensaje-seccion-c'],
						'type'=>DepDrop::TYPE_SELECT2,
						 'data' => [$id_data => $value_data],
						'pluginOptions'=>[
						
							'depends'=>['valor-seccion-c'],
							'placeholder' => 'Select...',
							'url'=>Url::to(['mensaje-novedad/mensaje']),
							//'params'=>['input-type-1', 'input-type-2']
						]
						
					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-2">
				  <p>&nbsp;</p>
				      <input type="text" class="form-control" name="txt-seccion-c" placeholder="Comentario"/> 
				  </div>
			   
			   
			   </div>			  
			   
			  
			  
			  <?php
				  
				  
			  }else{
				  
		   
		   ?>
		
			   <div class="row" >
			   
				  <div class="col-md-4">
				   <p>&nbsp;</p>
				  
				   <p><strong><?= $orden?></strong><?= '. '.$novedad->nombre?></p>
				  
				  </div>
				  
				  <div class="col-md-3">
				   <p>&nbsp;</p>
				    <?php
					
					   echo Select2::widget([
						'name' => 'valor-novedad-'.$novedad->id,
						'data' => $data_valor,
						'options' => [
							'id' => 'valor-novedad-'.$novedad->id,
							//'placeholder' => 'Estado',
														
						 ],


					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-3">
				   	<p>&nbsp;</p>
					<?php
					
					   //Obtener Mensajes Novedades
					  				   
					   $mensajes = $valores[0]->mensajeNovedades;				   
					   $id_data = ($mensajes != null ) ? $mensajes[0]->id : 1;
					   $value_data = ($mensajes != null ) ? $mensajes[0]->mensaje : '';
					   
					   
					
					   echo DepDrop::widget([
					    'name' => 'mensaje-novedad-'.$novedad->id,
						'options' => ['id' => 'mensaje-novedad-'.$novedad->id],
						'type'=>DepDrop::TYPE_SELECT2,
						 'data' => [$id_data => $value_data],   
						'pluginOptions'=>[
						
							'depends'=>['valor-novedad-'.$novedad->id],
							//'placeholder' => 'Select...',
							'url'=>Url::to(['mensaje-novedad/mensaje']),
							'initDepends' => ['valor-novedad-'.$novedad->id],
							//'initialize' => true
							//'params'=>['input-type-1', 'input-type-2']
						]
						
					   ]);
					
					?>
				  </div>
				  
				  <div class="col-md-2">
				  <p>&nbsp;</p>
				      <input type="text" name="text-novedad-<?= $novedad->id?>" class="form-control" placeholder="Comentario"/> 
				  </div>
			   
			   
			   </div>
			  <?php }?>
			  <?php endforeach;?>
		<?php endforeach;?>
		
		    <p style="clear: both;">&nbsp;</p>
		
			<?= $form->field($model, 'observaciones')->widget(Summernote::className(), []) ?>  
			
			   <!-- Fotografía -->
	   	<?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'image')->widget(FileInput::classname(), [
			//'options' => ['accept' => 'image/*'],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
							   'maxFileSize' => 5120,
			  ]
			 ]);

		?>	
		
		
		<div class="form-group">
           <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
        </div>
	   
	   </div>
	   

	   
	   
	</div>

    <input type="hidden" name="cantidad" id="cantidad" value="<?=$orden?>" />
    <?= Html::activeHiddenInput($model, 'usuario',['value' => Yii::$app->session['usuario-exito'] ])?>						

 




    <?php ActiveForm::end(); ?>

</div>

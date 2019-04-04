<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\TimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop ;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Incidente ';

$fotos = $model->fotosIncidente;


?>
  		<div class="form-group">

	    <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/incidente?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/incidente?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		 <?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/incidente/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>


		</div>      

     
	 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	 
	  <div class="col-md-12">
	  
	   <div class="col-md-12">
	     <label>Fecha</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha?>" readonly="readonly"/>
	   </div>
	   
	   <p>&nbsp;</p>

	   <div class="col-md-12">
	     
		 <label>Tipo de Incidente</label>
	     <input type="text"  class="form-control" value="<?= $model->novedad->nombre?>" readonly="readonly"/>
	   </div>
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	     
		 <label>Dependencia</label>
	     <input type="text"  class="form-control" value="<?= $model->dependencia->nombre?>" readonly="readonly"/>
	   </div>
	   
	   	<p>&nbsp;</p>
		
	   <div class="col-md-12">
	   
	   <div class="col-md-6">
	   
	    <label>Detalle</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'detalle',
				'value' => $model->detalle,
				'clientOptions' => [
				
	               //'height' => 55,

				]
			]) ?>
	   
	    </div>
		
		<div class="col-md-6">
		     <label>Fotografía</label>
		     <img class="img-responsive img-thumbnail" alt="imagen" src="<?=Yii::$app->request->baseUrl.$model->imagen?>"/>
			 
		</div>	
		
		
	   </div>
	   
	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Recomendaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'observacion',
				'value' => $model->recomendaciones,
					'clientOptions' => [
						
						   'height' => 55,

						]	
			]) ?>
	   
	   </div>
	   	    <p>&nbsp;</p>
	   
	   <div class="col-md-12">

	   
	      <h4 style="text-align: center;">Investigaciones anteriores</h4>
	   
	     <?php
		 
		 
		 
		 foreach($fotos as $key){
			 
			  
				
          ?>

			 <?php
			 
			 /**********************Rendering Image *******************************/
			 if($key->imagen != null && $key->imagen != ''){
				  
				  /**Validar imagen o pdf o xls*/
				  
				 if((strpos($key->imagen, 'pdf') !== false || strpos($key->imagen, 'docx') !== false || strpos($key->imagen, 'xlsx') === false ) ){
					  
				  
				  ?>
				  
				   
				    
				  
					<p>
					<a href="http://cvsc.com.co/sgs/web<?=$key->imagen?>" download>
					 <?=$key->imagen?>
					</a>
					</p>				  
				  

				 
				  
				  <?php
				  }else{
					  
				   ?>
				   
				   <label>Investigaciones Anteriores</label>
				  <img src="<?=Yii::$app->request->baseUrl.$key->imagen?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  

				  
				  <?php			   
				  }
				  
				  ?>

              
              <p>&nbsp;</p>
		  <?php		  

			 }
			 
		 }
		 
		 ?>
		 


	   
	   </div>
	   
 	   
	  </div>
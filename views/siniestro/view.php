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

$this->title = 'Siniestro ';

$fotos = $model->fotosSiniestro;


?>
  		<div class="form-group">

	    <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/siniestro?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/siniestro?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		 <?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/siniestro/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>


		</div>      

     
	 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	 
	  <div class="col-md-12">
	  
	   <div class="col-md-6">
	     <label>Fecha de creación</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha?>" readonly="readonly"/>
	   </div>
	   <div class="col-md-6">
	     
		 <label>Creada por</label>
	     <input type="text"  class="form-control" value="<?= $model->usuario?>" readonly="readonly"/>
		 
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	     
		 <label>Tipo de Siniestro</label>
	     <input type="text"  class="form-control" value="<?= $model->novedad->nombre?>" readonly="readonly"/>
	   </div>
	   	   <p>&nbsp;</p>
	   <div class="col-md-12">
	     
		 <label>Fecha de Siniestro</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha_siniestro?>" readonly="readonly"/>
	   </div>
       <p>&nbsp;</p>	   
	   <div class="col-md-12">
	     
		 <label>Dependencia</label>
	     <input type="text"  class="form-control" value="<?= $model->dependencia->nombre?>" readonly="readonly"/>
	   </div>
	   
	   	<p>&nbsp;</p>
		<div class="col-md-6">
		
		<label>Area</label>
	     <input type="text"  class="form-control" value="<?= $model->areaDependencia->nombre?>" readonly="readonly"/>
	     
	   </div>
	   <div class="col-md-6">
	     
		 <label>Zona</label>
	     <input type="text"  class="form-control" value="<?= $model->zonaDependencia->nombre?>" readonly="readonly"/>
	   </div>
	   
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Resumen de los hechos</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'resumen',
				'value' => $model->resumen,
				'clientOptions' => [
				
	               'height' => 55,

				]
			]) ?>
	   
	   </div>
	   
	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Observaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'observacion',
				'value' => $model->observacion,
					'clientOptions' => [
						
						   'height' => 120,

						]	
			]) ?>
	   
	   </div>
	   	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Recomendaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'recomendaciones',
				'value' => $model->recomendaciones,
				'clientOptions' => [
				
				   'height' => 55,

				]
			]) ?>
	   
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Registro Fotografico</label>
	   
	     <?php
		 
		 foreach($fotos as $foto){
			 
			 if($foto->imagen != null && $foto->imagen != ''){
				
          ?>
              <img src="<?=Yii::$app->request->baseUrl.$foto->imagen?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  
              <p>&nbsp;</p>
		  <?php		  

			 }
			 
		 }
		 
		 ?>
		 


	   
	   </div>
	   
 	   
	  </div>
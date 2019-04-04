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

$this->title = 'Capacitación ';

$capacitacion_instructores = $model->capacitacionInstructor;

$instructores = array();



foreach($capacitacion_instructores as $key){
	
	$instructores [] = $key->instructor;
	
}

$capacitacionDependencias = $model->capacitacionDependencias;
$dependencias = array();

if($capacitacionDependencias != null){
	
	foreach($capacitacionDependencias as $key){
		
		$dependencias [] = array('nombre' => $key->dependencia->nombre, 'cantidad' => $key->cantidad);
		
	}
	
}



?>
		<div class="form-group">
        <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/capacitacion?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/capacitacion?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		
        <?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/capacitacion/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>

		</div>      

	 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	 
	  <div class="col-md-12">
	  
	   <div class="col-md-6">
	     <label>Fecha de creación</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha?>" readonly="readonly"/>
	   </div>
	   <div class="col-md-6">
	     
		 <label>Fecha de capacitación</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha_capacitacion?>" readonly="readonly"/>
	   </div>
	   
	   	<p>&nbsp;</p>
		<div class="col-md-6">
	     <label>Creada por</label>
	     <input type="text"  class="form-control" value="<?= $model->usuario?>" readonly="readonly"/>
	   </div>
	   <div class="col-md-6">
	     
		 <label>Instructor</label>
	     <input type="text"  class="form-control" value="<?= $instructores[0]?>" readonly="readonly"/>
	   </div>
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	     
		 <label>Tema</label>
	     <input type="text"  class="form-control" value="<?= $model->novedad->nombre?>" readonly="readonly"/>
	   </div>
	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Observaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'observaciones',
				'value' => $model->observaciones,
				'clientOptions' => [
				
				   'enable' => false,

				]
			]) ?>
			
			
	   
	   </div>
	   	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Lugar(es)</label>
	   
	       <table class="table">
	         
			 <thead>
			    
				<tr>
				  
				  <td>Nombre</td>
				  <td>Cantidad</td>
				
				</tr>
			 
			 </thead>
			 
			 <tbody>
			 
			  <?php if($dependencias != null):?>
				<?php foreach($dependencias as $key):?>
				
				   <tr>
				   
				     <td><?=$key['nombre']?></td>
					 <td><?=$key['cantidad']?></td>
				   
				   </tr>
				    
				<?php endforeach;?>
			  <?php endif;?>
			    

			 </tbody>
			 
           </table>
			
			
	   
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	  
	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->foto != null && $model->foto != ''){
			  
			  ?>
			   <label>Registro Fotografico</label>
			  <img src="<?=Yii::$app->request->baseUrl.$model->foto?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  
			  
			  <?php
			  
		  }
			  
			  
		 ?>


	   
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	   
	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->lista != null && $model->lista != ''){
			  
			  /**Validar imagen o pdf o xls*/
			  
			 if( (strpos($model->lista, 'pdf') !== false || strpos($model->lista, 'xls') !== false || strpos($model->lista, 'xlsx') !== false ) ){
				  
			  
			  ?>
			  
			  <label>Acta de asistencia</label>
			  
			    <p>
				<a href="http://cvsc.com.co/sgs/web<?=$model->lista?>" download>
				 <?=$model->lista?>
				</a>
			    </p>
			 
			  
			  <?php
			  }else{
				  
               ?>
              <label>Acta de asistencia</label>
              <img src="<?=Yii::$app->request->baseUrl.$model->lista?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  
			  <?php			   
			  }
			  
			  ?>
	  
			  <?php
			  
		  }
			  
			  
		 ?>

	   
	   </div>
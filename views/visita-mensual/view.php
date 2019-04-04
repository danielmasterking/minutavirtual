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
/* @var $model app\models\Distrito */

$this->title = 'Detalle de Visita Semestral';
?>
 		<div class="form-group">

	    <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/visita?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/mensual?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		
		<?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/visita-mensual/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>


		</div>      

     
	 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	 
	  <div class="col-md-12">
	   <div class="col-md-12">
	   <p>&nbsp;</p>
	   <label>Fecha Visita</label>
	   <input type="text" class="form-control" value="<?=$model->fecha_visita?>" readonly />
	   
	   </div>
	   </div>
	   
	  <div class="col-md-12">
	   <div class="col-md-12">
	   <p>&nbsp;</p>
	   <label>Dependencia</label>
	   <input type="text" class="form-control" value="<?=$model->dependencia->nombre?>" readonly />
	   
	   </div>
	   </div>	   
	   
	  <div class="col-md-12">
	   <div class="col-md-6">
	   <p>&nbsp;</p>
	   <label>Atendió</label>
	   <input type="text" class="form-control" value="<?=$model->atendio?>" readonly />
	   
	   </div>
	   
	   <div class="col-md-6">
	   <p>&nbsp;</p>
	   <label>Otro</label>
	   <input type="text" class="form-control" value="<?=$model->otro?>" readonly />
	   
	   </div>	   
	   </div>

	  <div class="col-md-12">
	   <div class="col-md-12">
	   <p>&nbsp;</p>
	   <label>Observaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'detalle',
				'value' => $model->detalle,
				'clientOptions' => [
				
				   'enable' => false,

				]
			]) ?>
	   </div>		   


      </div>
	  
	  <div class="col-md-12">
	   <div class="col-md-12">
	   <p>&nbsp;</p>
	   <label>Recomendaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'recomendaciones',
				'value' => $model->recomendaciones,
				'clientOptions' => [
				
				   'enable' => false,

				]
			]) ?>
	   </div>		   


      </div>

	   <p>&nbsp;</p>
	   <div class="col-md-12">
	   
	   
	     <?php
		 
		 $archivos = $model->archivos;
		 /**********************Rendering Image *******************************/
		  if($archivos != null){
        ?>

			  <label>Archivo</label>
			  
			    <p>
				<a href="http://cvsc.com.co/sgs/web<?=$archivos[0]->archivo?>" download>
				 <?=$archivos[0]->archivo?>
				</a>
			    </p>

	  
			  <?php
			  
		  }
			  
			  
		 ?>
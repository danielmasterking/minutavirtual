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

$this->title = 'Comité '.$model->id;


?>
<div class="container" style="margin-top:5px;padding-top:5px;">
<?= $this->render('_cambio') ?>
<div class="row">

<?= $this->render('_menu') ?>
<div class="rol-index col-md-10">

 <div class="col-md-12">
 
  		<div class="form-group">

		<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/index',['class'=>'btn btn-primary']) ?>


		</div>      

     
	 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	 
	  <div class="col-md-12">
	  
	   <div class="col-md-6">
	     <label>Fecha de creación</label>
	     <input type="text"  class="form-control" value="<?= $model->fecha?>" readonly="readonly"/>
	   </div>
	   <div class="col-md-6">
	     
		 <label>Creado por</label>
	     <input type="text"  class="form-control" value="<?= $model->usuario?>" readonly="readonly"/>
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	     
		 <label>Tipo de comité</label>
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
	   <label>Registro Fotografico</label>
	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->foto != null && $model->foto != ''){
			  
			  ?>
			  
			  <img src="<?=Yii::$app->request->baseUrl.$model->foto?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  
			  
			  <?php
			  
		  }else{
			  
			  
		 ?>
		    
			<p>Fotografía no cargada al crear Comité.</p>
              
		<?php

		  }		 
		 
		 ?>

	   
	   </div>
	   
	   <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Acta de asistencia</label>
	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->lista != null && $model->lista != ''){
			  
			  /**Validar imagen o pdf o xls*/
			  if(strpos($model->lista, 'pdf') === false || strpos($model->lista, 'xls') === false || strpos($model->lista, 'xlsx') === false){
				  
			  
			  ?>
			  
			  <iframe src="http://docs.google.com/gview?url=http://cvsc.com.co/sgs/web<?=Yii::$app->request->baseUrl.$model->lista?>&embedded=true" width="100%" height="600px" scrolling="auto"> </iframe>
			  
			  <?php
			  }else{
				  
               ?>
 
              <img src="<?=Yii::$app->request->baseUrl.$model->lista?>" alt="Fotografía" class="img-responsive img-thumbnail"/>			  
			  <?php			   
			  }
			  
			  ?>
			  
			  
			  
			  <?php
			  
		  }else{
			  
			  
		 ?>
		    
			<p>Acta no cargada al crear comité.</p>
              
		<?php

		  }		 
		 
		 ?>

	   
	   </div>	   
	   
	   
	   
	  </div>
 
 
 </div>
 

   
     
</div>
</div>
</div>

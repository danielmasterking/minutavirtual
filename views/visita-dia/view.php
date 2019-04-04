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

$this->title = 'Visita Quincenal ';
$detalle_visita = $model->detalle; //array con detalle de la visita
$seguridad_electronica = false;



?>
 		<div class="form-group">

	    <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/visita?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/visita?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		<?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/visita-dia/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>


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
	     
		 <label>Dependencia</label>
	     <input type="text"  class="form-control" value="<?= $model->dependencia->nombre?>" readonly="readonly"/>
		 
	   </div>
	   
	   <p>&nbsp;</p>
	   
	   <div class="col-md-6">
	     <label>Atendió Visita</label>
	     <input type="text"  class="form-control" value="<?= $model->responsable?>" readonly="readonly"/>
	   </div>
	   
	   <div class="col-md-6">
	     
		 <label>Otro</label>
	     <input type="text"  class="form-control" value="<?= $model->otro?>" readonly="readonly"/>
		 
	   </div>
	    <p>&nbsp;</p>
	  
	   <!----- Comienzo detalle de novedades ---->
	    <div class="col-md-12">
	       
		   <?php foreach($detalle_visita as $detalle):?>
		         
			  <?php if($detalle->novedad->id != 10):?>
			  
				 <div class="row">
				 
				     <div class="col-md-4">
					    <p>&nbsp;</p>
						 <p><strong><?= $detalle->novedad->id?></strong><?= '. '.$detalle->novedad->nombre?></p>
						
					 </div>
					 
				  <div class="col-md-2">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->resultado->nombre?>" readonly="readonly"/>

                  </div>	

				  <div class="col-md-4">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->mensajeNovedad->mensaje?>" readonly="readonly"/>

                  </div>

				  <div class="col-md-2">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->observacion?>" readonly="readonly"/>

                  </div>					  
				 
				 </div>
				 
			<?php  else:?>	 
			
			 <?php if($seguridad_electronica === false):?>
			
			  <div class="row">
			  
			     <div class="col-md-4">
				   <p>&nbsp;</p>
				  
				   <p><strong><?= $detalle->novedad->id?></strong><?= '. '.$detalle->novedad->nombre?></p>
				  
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
				  
				  <!-- Secciones A -->
				  <div class="row">
				  
				     <div class="col-md-4">
					   <p>&nbsp;</p>
					    <div class="row">
						
						<div class="col-md-4">
					   
					      <p><strong>*</strong> Sección</p>
					   
					     </div>
						 
						 <div class="col-md-8">
					   
					      <input type="text"  class="form-control" value="<?= $detalle->seccion->seccion->nombre?>" readonly="readonly"/>
					   
					     </div>
						
						</div>
					 
					 </div>
					 
				 <div class="col-md-2">
				   <p>&nbsp;</p>
                    <input type="text"  class="form-control" value="<?= $detalle->resultado->nombre?>" readonly="readonly"/>
				 </div>
				 
				  <div class="col-md-4">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->mensajeNovedad->mensaje?>" readonly="readonly"/>

                  </div>

				  <div class="col-md-2">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->observacion?>" readonly="readonly"/>

                  </div>					 
				       
					   
				</div>


                <?php $seguridad_electronica = true;?>	

              <?php else:?>
			  
			  	<div class="row">
				  
				     <div class="col-md-4">
					   <p>&nbsp;</p>
					    <div class="row">
						
						<div class="col-md-4">
					   
					      <p><strong>*</strong> Sección</p>
					   
					     </div>
						 
						 <div class="col-md-8">
					   
					      <input type="text"  class="form-control" value="<?= $detalle->seccion->seccion->nombre?>" readonly="readonly"/>
					   
					     </div>
						
						</div>
					 
					 </div>
					 
				 <div class="col-md-2">
				   <p>&nbsp;</p>
                    <input type="text"  class="form-control" value="<?= $detalle->resultado->nombre?>" readonly="readonly"/>
				 </div>		

				  <div class="col-md-4">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->mensajeNovedad->mensaje?>" readonly="readonly"/>

                  </div>

				  <div class="col-md-2">
				   <p>&nbsp;</p>
				   <input type="text"  class="form-control" value="<?= $detalle->observacion?>" readonly="readonly"/>

                  </div>					 
				       
					   
				   </div>
                      
                
			  
			  <?php endif;?>
				 
		     <?php  endif;?>
		   <?php  endforeach;?>
		   

		   
	   </div>
	   <!------ Fin detalle de Novedades --------> 
	   	   
	    <p>&nbsp;</p>
	   <div class="col-md-12">
	   <label>Observaciones</label>
	   
	     <?= Summernote::widget([
		 
				'name' => 'observacion',
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
		    
			<p>Fotografía no cargada al crear Visita.</p>
              
		<?php

		  }		 
		 
		 ?>

	   
	   </div>
	   <div class="col-md-12">
  
 	   
	  </div>
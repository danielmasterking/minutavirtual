<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\popover\PopoverX;
use kartik\money\MaskMoney;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;


date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());


if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

$data_dependencias = array();

foreach($dependencias as $value){
	

   $data_dependencias[$value->codigo] =  $value->nombre;   

     
}

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="col-md-12">
	
	
	<div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? 'Asignar Presupuesto Inicial' : 'Actualizar', ['class' => 'btn btn-primary btn-lg pull-right']) ?>
    </div>	
	
	

	<p>&nbsp;</p>
	
	<div class="col-md-12">
	
	  <?php if( !isset($actualizar) ):?>	
	   <div  class="col-md-6">
	   
		   <?=

  		   $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
			   
			   'data' => $data_dependencias,
			
			  ])

		 ?>
	   
	   
	   </div>
	   <?php endif;?>	
	   
	   <div  class="col-md-6">
	   
	     <?= $form->field($model, 'orden_interna')->textInput() ?>
	   
	   
	   </div>
	
	
	</div>
	

		
			<div class="col-md-12">
			  <div class="col-md-12">
			   		
				   <?= $form->field($model, 'fecha_asignacion')->widget(DateControl::classname(), [
						  'autoWidget'=>true,
						 'displayFormat' => 'php:Y-m-d',
						 'saveFormat' => 'php:Y-m-d',
						  'type'=>DateControl::FORMAT_DATE,
			 
				   ]);?>
			   </div>
			</div>		
		

	
	
	<?php if( !isset($actualizar) ):?>	
		<div class="col-md-12">
	
	   <div  class="col-md-6">
	   
		<?= $form->field($model, 'presupuesto_seguridad')->textInput(['value' => '0']) ?>
	   
	   
	   </div>
	   
	   <div  class="col-md-6">
	   
	     <?= $form->field($model, 'presupuesto_riesgo')->textInput(['value' => '0']) ?>
	   
	   
	   </div>
	
	
	</div>
	
	<?php endif;?>	
	    
	 	
		
		
		
		<p>&nbsp;</p>
		
		
	 <?php ActiveForm::end(); ?>				

    </div>
	
	
<?php if( !isset($actualizar) ):?>	
	
<?php $form2 = ActiveForm::begin(); ?>	
	<div class="col-md-12">
	<table class="table table-responsive">
		   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Dependencia</th>
				 <th>No. de Orden</th>
				 <th>Seguridad</th>
				 <th>Riesgos</th>
				 <th>Total</th>
				 <th>Finalización Desarrollo</th>
				 <th></th>
				 <th></th>
			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($presupuestos as $key):?>
		        
		           <tr>
				    <td><?php
					
					
		
					if(in_array("administrador", $permisos) ){
					   
					  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/presupuesto/update?id='.$key->id);
					  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/presupuesto/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
	  
					 }
						?>
					</td>
				     <td><?= $key->dependencia->nombre?></td>
					 <td><?= $key->orden_interna?></td>
					 <td>
					 
					 <?php
					 
					   	echo MaskMoney::widget([
						
							'name' => 'valor1-view'.$key->id,
							'value' => $key->presupuesto_seguridad_actual,
							'options' => ['readonly' => 'readonly']
						]);
					 
					 ?>
					 
					 
					 
					 
					 </td>
					 <td>
					 
					 <?php
					 
					   	echo MaskMoney::widget([
						
							'name' => 'valor2-view'.$key->id,
							'value' => $key->presupuesto_riesgo_actual,
							'options' => ['readonly' => 'readonly']
						]);
					 
					 ?>
					 

					 
					 </td>
					 <td>
					 <?php
					 
					   	echo MaskMoney::widget([
						
							'name' => 'total-view'.$key->id,
							'value' => $key->presupuesto_actual,
							'options' => ['readonly' => 'readonly']
						]);
					 
					 ?>					 

					 
					 </td>
					 
					 <td>
					 
					   <?= $key->fecha_asignacion ?>
					 
					 
					 </td>
					 
					 
					 <td>
					     <?php
						 
						    $auditorias = $key->dependencia->auditoriaPresupuesto;
						    
						    PopoverX::begin([
								'placement' => PopoverX::ALIGN_TOP,
								'toggleButton' => ['label'=>'<i class="fa fa-plus" aria-hidden="true"></i>', 'class'=>'btn btn-default btn-primary'],
								'header' => '<i class="glyphicon glyphicon-lock"></i> Valor a sumar',
								'footer'=>Html::submitButton('Seguridad', ['name' => 'seguridad','class'=>'btn btn-sm btn-primary']).Html::submitButton('Riesgos', ['name' => 'riesgos','class'=>'btn btn-sm btn-primary'])
	
							]);
							

							
							?>
							<input name="txt-valor-<?php echo $key->id; ?>" id="txt-valor-<?php echo $key->id; ?>" class="form-control" value="0"  type="text" />
							<input name="txt-dep-<?php echo $key->dependencia->codigo; ?>" id="txt-dep-<?php echo $key->dependencia->codigo; ?>" class="form-control" value="<?=$key->dependencia->codigo?>"  type="hidden" />
							
							
							
							
							
							<?php
							
							PopoverX::end();
						 
						 
						 ?>				 					 					 
					 
					 </td>
					 
					  <td>
					     <?php
						    
						    PopoverX::begin([
								'placement' => PopoverX::ALIGN_RIGHT,
								'toggleButton' => ['label'=>'<i class="fa fa-history" aria-hidden="true"></i>', 'class'=>'btn btn-default btn-primary'],
								'header' => '<i class="glyphicon glyphicon-time"></i> Historial',
								
	
							]);
							
							
							if($auditorias != null){
								
								
								
								foreach($auditorias as $aud){
									
									?>
									
																
										 <div class="col-md-12">
										 
										   <p><?=$aud->fecha.' '.$aud->usuario.' '.$aud->operacion.' $'.$aud->valor.' a presupuesto de '.$aud->area?></p>
										   
										 
										 </div>
									
									
									<?php
									
									
								}
							
							?>


							
							
							<?php
							
							   }else{
								   
							?>
							
							 <div class="col-md-12">
							 
							   <p>No existe historial</p>
							   
							 
							 </div>


                            <?php							
							   
							   }
							
							PopoverX::end();
						 
						 
						 ?>				 					 					 
					 
					 </td>
				   
				   
				   </tr>
		   
		       <?php  endforeach;?>
		   
		   </tbody>
		
		
		</table>
	  </div>

	</div>

 	 <?php ActiveForm::end(); ?>	   

<?php endif;?>


</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;



$data_productos = array();

foreach($productos as $key){
	
	$data_productos[$key->material] = $key->material.'-'.$key->texto_breve; 
	
}

foreach($productos_especiales as $key){
	
	$data_productos[$key->material] = $key->material.'-'.$key->texto_breve; 
	
}

/* @var $this yii\web\View */
/* @var $model app\models\Equivalencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equivalencia-form">


    <?php $form = ActiveForm::begin(); ?>

	  
	  <div class="col-md-12">
	  
	    <div class="col-md-6">
		
			  <?= $form->field($model, 'elemento')->dropDownList(['CC' => 'Cuenta Contable', 
														  'OI' => 'Orden Interna',
													]) ?>	
		
		</div>
		
		<div class="col-md-6">
		
			  <?= $form->field($model, 'tipo')->dropDownList(['A' => 'Activo', 
													  'K' => 'Gasto',
													  'F' => 'Proyecto',
												]) ?>	
		
		</div>
	  
	  </div>
	  
	  <div class="col-md-12">
	  
	    <div class="col-md-4">
		
		  <?= $form->field($model, 'cebe')->dropDownList([ '' => '',
		                                                  '1' => '1', 
														  '2' => '2',
														  '3' => '3',
														  '4' => '4', 
														  '5' => '5',
														  '6' => '6',
														  '7' => '7', 
														  '8' => '8',
														  '9' => '9',
													]) ?>	
		
		</div>
		
		<div class="col-md-4">
		
		
			<?=

			   $form->field($model, 'producto')->widget(Select2::classname(), [
			   
			   'data' => $data_productos,
			   'options' => ['placeholder' => 'Opcional'],
			
			  ])

			 ?>
		
			
		
		</div>
		
		<div class="col-md-4">
		
		


	
	  <?= $form->field($model, 'todo')->dropDownList(['N' => 'NO', 
														  'S' => 'SI',
													]) ?>	
		
		
		</div>
	  
	  </div>
	  
	  <div class="col-md-12">
	  
		  <div class="col-md-8">
		  
		     <?= $form->field($model, 'cuenta')->textInput(['maxlength' => true]) ?>
		  
		  </div>

		  <div class="col-md-4">
		  
		      <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
		  
		  </div>	  		  
	  
	  
	  </div>
	  

	  

    <?php ActiveForm::end(); ?>
	
	  <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	  
	     <thead>
		    
			<tr>
			   <th></th>
			   <th>Elemento</th>
			   <th>Tipo</th>
			   <th>Cebe</th>
			   <th>Producto</th>
			   <th>Todo</th>
			   <th>Cuenta</th>
			   
			
			</tr>
		 
		 </thead>
		 
		 <tbody>
		 
		     <?php foreach($equivalencias as $key):?>
			 
			   <tr>
			   
			      <td><?php
				  
				  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/equivalencia/delete?id='.$key->id,['data-method'=>'post']);
				  
				  
				  ?></td>
			   
			      <td>
				      
					  <?php
					  
					     if($key->elemento == 'CC'){
							 
							echo 'CUENTA CONTABLE' ;
							 
						 }else{
							 
							 echo 'ORDEN INTERNA';
							 
						 }
					  
					  
					  ?>
				  
				  </td>
				  
			      <td>
				      
					  <?php
					  
					     if($key->tipo == 'A'){
							 
							echo 'ACTIVO' ;
							 
						 }else{
							 
							 if($key->tipo == 'K'){
							
                                echo 'GASTO';							
								 
							 }else{
								 
							   echo 'PROYECTO';	 
								 
							 }
							 
							 
							 
						 }
					  
					  
					  ?>
				  
				  </td>		

                  <td><?= $key->cebe ?></td>
				  <td><?= $key->producto ?></td>
                  <td><?= $key->todo ?></td>
                  <td><?= $key->cuenta ?></td>				   
			   
			   
			   </tr>
			 
			 <?php endforeach; ?>
			 
		 
		 </tbody>
	  
	  </table>	

</div>

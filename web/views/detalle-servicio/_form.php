<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\DetalleServicio */
/* @var $form yii\widgets\ActiveForm */
$data_servicios = array();
foreach ($servicios as $value) {
    
    $data_servicios[$value->id] = $value->nombre;
}

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


?>

<div class="detalle-servicio-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>	
	
	<?=

       $form->field($model, 'servicio_id')->widget(Select2::classname(), [
       
	   'data' => $data_servicios,
    
      ])


     ?>	

    <?= $form->field($model, 'ano')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
	
	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Código</th>
				 <th>Descripción</th>
				 <th>Precio</th>
				 <th>Servicio</th>
				 <th>Año</th>


			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($codigos as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
						
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/detalle-servicio/update?id='.$key->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/detalle-servicio/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }						
						
						
					}
										

						?>
					</td>
					<td><?=$key->codigo?></td>
					<td><?=$key->descripcion?></td>
					<td><?php
					 
					   	echo MaskMoney::widget([
						
							'name' => 'valor2-view'.$key->id,
							'value' => $key->precio,
							'options' => ['readonly' => 'readonly']
						]);
					 
					 ?></td>
					<td><?=$key->servicio->nombre?></td>
					<td><?=$key->ano?></td>

                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>		

</div>

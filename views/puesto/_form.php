<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleServicio */
/* @var $form yii\widgets\ActiveForm */
$data_servicios = array();
foreach ($codigos as $value) {
    
    $data_servicios[$value->id] = $value->nombre;
}

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>

<div class="puesto-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>
	

	
	<?=

       $form->field($model, 'servicio_id')->widget(Select2::classname(), [
       
	   'data' => $data_servicios,
    
      ])


     ?>		

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
	
		<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Nombre</th>
				 <th>Servicio</th>


			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($puestos as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					  
                      if($permisos != null){
						  
						 if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/puesto/update?id='.$key->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/puesto/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						  
						  
					  }					  

					?>
					</td>
					<td><?=$key->nombre?></td>
					<td><?=$key->servicio->nombre?></td>

                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>	

</div>

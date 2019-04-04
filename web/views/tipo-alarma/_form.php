<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Servicio */
/* @var $form yii\widgets\ActiveForm */
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}
?>

<div class="servicio-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>


    <?php ActiveForm::end(); ?>
	
	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Nombre</th>


			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($alarmas as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/tipo-alarma/update?id='.$key->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/tipo-alarma/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
					?>
					</td>
					<td><?=$key->nombre?></td>

                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>	

</div>

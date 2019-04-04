<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

/* @var $this yii\web\View */
/* @var $model app\models\Dia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dia-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>
	
    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'festivos')->textInput() ?>

    <?= $form->field($model, 'ano')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
	
	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Total</th>
			     <th>Festivos</th>
				 <th>Año</th>

			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($dias as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/dia/update?id='.$key->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/dia/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
						?>
					</td>
					<td><?=$key->total?></td>
					<td><?=$key->festivos?></td>
				    <td><?=$key->ano?></td>


                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>
		

</div>

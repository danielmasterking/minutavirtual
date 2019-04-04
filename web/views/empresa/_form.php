<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'nit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

	<?php
		 // Usage with ActiveForm and model
		 echo $form->field($model, 'image')->widget(FileInput::classname(), [
		//'options' => ['accept' => 'image/*'],
		'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
						   'maxFileSize' => 5120,
		  ]
		 ]);

	?>
	
	
    <?php ActiveForm::end(); ?>

	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Nit</th>
			     <th>Nombre</th>
				 <th></th>

			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($empresas as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/empresa/update?id='.$key->nit);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/empresa/delete?id='.$key->nit,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
						?>
					</td>
					<td><?=$key->nit?></td>
					<td><?=$key->nombre?></td>
					<td>
					  <img alt="logo" src="<?=Yii::$app->request->baseUrl.$key->logo?>"/>
					
					
					</td>


                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>
	
	



</div>

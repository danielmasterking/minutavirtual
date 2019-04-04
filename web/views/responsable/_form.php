<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Responsable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="responsable-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group">

		<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$id,['class'=>'btn btn-primary']) ?>


	</div>   

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
     
	 <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>
	 
	 <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
	<?php 
	    if(!isset($actualizar)){
			
		   echo Html::activeHiddenInput($model, 'centro_costo_codigo',['value' => $id]); 	
		}
	     
		 
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Información dependencia';
?>
<div class="form-group">
<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
</div> 
    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
<div class="row">
<div class="col-md-12">
  <h3 style="text-align: center;">Cargar Imagen a Dependencia</h3>
	 	<?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'image')->widget(FileInput::classname(), [
			//'options' => ['accept' => 'image/*'],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
							   'maxFileSize' => 5120,
			  ]
			 ]);
		?>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="cambiar" value="Guardar" />
    </div>
</div>
</div>



<?php ActiveForm::end(); ?>
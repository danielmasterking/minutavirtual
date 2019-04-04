<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NovedadCategoriaVisita */
/* @var $form yii\widgets\ActiveForm */

$categorias_array = array();

foreach($categorias as $categoria){

   $categorias_array[$categoria->id] = $categoria->nombre;	
	
}

?>

<div class="novedad-categoria-visita-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
	<?= $form->field($model, 'categoria_visita_id')->dropDownList($categorias_array) ?>
	

    <?= $form->field($model, 'criterio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

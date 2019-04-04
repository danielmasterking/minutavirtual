<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Equivalencias';	

?>
   <?php if(isset($done) && $done === '200'):?>
   
     <p style="text-align: center;" class="alert alert-success">Equivalencia agregada.</p>
   
   <?php endif;?>
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
        'equivalencias' => $equivalencias,
		'productos_especiales' => $productos_especiales,
		'productos' => $productos,
    ]) ?>
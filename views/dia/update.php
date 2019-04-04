<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Días del Año';	

?>
      <?= $this->render('_tabs',['dia' => $dia]) ?>

   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'dias' => $dias,
		'actualizar' => 's',
	
    ]) ?>
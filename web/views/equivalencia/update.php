<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Actualización de presupuesto';	

?>
      <?= $this->render('_tabsFinanciera',['presupuesto' => $presupuesto]) ?>

     
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'dependencias' => $dependencias,
		'presupuestos' => $presupuestos,
		'llaves' => $llaves,
		'actualizar' => 'S',
	
    ]) ?>
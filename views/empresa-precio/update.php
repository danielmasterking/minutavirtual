<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Actualizar Precios Empresa';	

?>
<?= $this->render('_tabs',['empresa' => $empresa]) ?>
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'alarmas' => $alarmas,
		'empresas' => $empresas,
        'actualizar' => 's',	 
		'precios' => $precios,		
	
    ]) ?>
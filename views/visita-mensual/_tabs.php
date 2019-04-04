<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$periodica = isset($periodica) ? $periodica : '';
$eventos = isset($eventos) ? $eventos : '';
$mensual = isset($mensual) ? $mensual : '';
$personales = isset($personales) ? $personales : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" class="<?= $periodica ?>"><?php echo Html::a('Visita Quincenal',Yii::$app->request->baseUrl.'/visita-dia/create'); ?></li>
	 <li role="presentation" class="<?= $eventos ?>"><?php echo Html::a('Solicitud o Activación',Yii::$app->request->baseUrl.'/evento/create'); ?></li>
     <li role="presentation" class="<?= $mensual ?>"><?php echo Html::a('Visita Semestral',Yii::$app->request->baseUrl.'/visita-mensual/create'); ?></li>
     
   </ul>
     
   </div>
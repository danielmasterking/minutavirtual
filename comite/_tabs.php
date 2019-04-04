<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$nuevo = isset($nuevo) ? $nuevo : '';
$marcas = isset($marcas) ? $marcas : '';
$cordinadores = isset($cordinadores) ? $cordinadores : '';
$personales = isset($personales) ? $personales : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" class="<?= $nuevo ?>"><?php echo Html::a('Nuevo',Yii::$app->request->baseUrl.'/comite/create'); ?></li>
     <li role="presentation" class="<?= $marcas ?>"><?php echo Html::a('Distritos',Yii::$app->request->baseUrl.'/comite/marcas'); ?></li>
	 <li role="presentation" class="<?= $cordinadores ?>"><?php echo Html::a('Cordinadores',Yii::$app->request->baseUrl.'/comite/cordinadores'); ?></li>
	 <li role="presentation" class="<?= $personales ?>"><?php echo Html::a('Mis Comités',Yii::$app->request->baseUrl.'/comite/personales'); ?></li>
     
     
   </ul>
     
   </div>
<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$empresa = isset($empresa) ? $empresa : '';
$alarma = isset($alarma) ? $alarma : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $alarma ?>"><?php echo Html::a('Tipo Alarma',Yii::$app->request->baseUrl.'/tipo-alarma/create'); ?></li>
     <li role="presentation" class="<?= $empresa ?>"><?php echo Html::a('Precios',Yii::$app->request->baseUrl.'/empresa-precio/create'); ?></li>

	 </ul>
     
   </div>
<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$incidente = isset($incidente) ? $incidente : '';
$merma = isset($merma) ? $merma : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" class="<?= $incidente ?>"><?php echo Html::a('Incidentes',Yii::$app->request->baseUrl.'/incidente/create'); ?></li>
	 <li role="presentation" class="<?= $merma ?>"><?php echo Html::a('Mermas',Yii::$app->request->baseUrl.'/merma/create'); ?></li>
     
     
   </ul>
     
   </div>
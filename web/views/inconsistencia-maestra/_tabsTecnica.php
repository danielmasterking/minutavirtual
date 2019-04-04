<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$pedido = isset($pedido) ? $pedido : '';
$inconsistencia = isset($inconsistencia) ? $inconsistencia : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $pedido ?>"><?php echo Html::a('Pedidos',Yii::$app->request->baseUrl.'/pedido/revision-tecnica'); ?></li>
     <li role="presentation" class="<?= $inconsistencia ?>"><?php echo Html::a('Aprobación Anticipada',Yii::$app->request->baseUrl.'/inconsistencia-general/create'); ?></li>
      
   </ul>
     
   </div>
<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$pedido = isset($pedido) ? $pedido : '';
$presupuesto = isset($presupuesto) ? $presupuesto : '';
$activos = isset($activos) ? $activos : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 <li role="presentation" class="<?= $presupuesto ?>"><?php echo Html::a('Presupuesto',Yii::$app->request->baseUrl.'/presupuesto/create'); ?></li>
     <li role="presentation" class="<?= $pedido ?>"><?php echo Html::a('Pedidos',Yii::$app->request->baseUrl.'/pedido/revision-financiera'); ?></li>
     <li role="presentation" class="<?= $activos ?>"><?php echo Html::a('Activos',Yii::$app->request->baseUrl.'/pedido/codigo-activos'); ?></li>
      
   </ul>
     
   </div>
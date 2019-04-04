<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$pedido = isset($pedido) ? $pedido : '';
$presupuesto = isset($presupuesto) ? $presupuesto : '';
$activos = isset($activos) ? $activos : '';
$historico = isset($historico) ? $historico : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 <li role="presentation" class="<?= $presupuesto ?>"><?php echo Html::a('Presupuesto',Yii::$app->request->baseUrl.'/presupuesto/create'); ?></li>
     <li role="presentation" class="<?= $pedido ?>"><?php echo Html::a('Pedidos',Yii::$app->request->baseUrl.'/pedido/revision-financiera'); ?></li>
	 <li role="presentation" class="<?= $historico ?>"><?php echo Html::a('Historico',Yii::$app->request->baseUrl.'/pedido/historico-financiera'); ?></li>
	 
      
   </ul>
     
   </div>
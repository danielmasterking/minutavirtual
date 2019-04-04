<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$normal = isset($normal) ? $normal : '';
$especial = isset($especial) ? $especial : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $normal ?>"><?php echo Html::a('Pedidos',Yii::$app->request->baseUrl.'/pedido/create'); ?></li>
     <li role="presentation" class="<?= $especial ?>"><?php echo Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/create-especiales'); ?></li>
      
   </ul>
     
   </div>
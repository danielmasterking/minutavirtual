<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$proveedor = isset($proveedor) ? $proveedor : '';
$maestra = isset($maestra) ? $maestra : '';
$maestraEspecial = isset($maestraEspecial) ? $maestraEspecial : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $proveedor ?>"><?php echo Html::a('Proveedor',Yii::$app->request->baseUrl.'/proveedor/index'); ?></li>
     <li role="presentation" class="<?= $maestra ?>"><?php echo Html::a('Maestra',Yii::$app->request->baseUrl.'/maestra-proveedor/index'); ?></li>
	 <li role="presentation" class="<?= $maestraEspecial ?>"><?php echo Html::a('Maestra Especial',Yii::$app->request->baseUrl.'/maestra-especial/index'); ?></li>
      
   </ul>
     
   </div>
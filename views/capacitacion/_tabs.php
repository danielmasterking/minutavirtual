<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$nuevo = isset($nuevo) ? $nuevo : '';
$personales = isset($personales) ? $personales : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" class="<?= $nuevo ?>"><?php echo Html::a('Nueva',Yii::$app->request->baseUrl.'/capacitacion/create'); ?></li>
    
	 
     
     
   </ul>
     
   </div>
<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$indicador = isset($indicador) ? $indicador : '';
$periodicidad = isset($periodicidad) ? $periodicidad : '';
$metrica = isset($metrica) ? $metrica : '';
$macroactividad = isset($macroactividad) ? $macroactividad : '';
$microactividad = isset($microactividad) ? $microactividad : '';
$formato = isset($formato) ? $formato : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $indicador ?>"><?php echo Html::a('Componente',Yii::$app->request->baseUrl.'/indicador/index'); ?></li>
     <li role="presentation" class="<?= $periodicidad ?>"><?php echo Html::a('Periodicidad',Yii::$app->request->baseUrl.'/periodicidad/index'); ?></li>
     <li role="presentation" class="<?= $metrica ?>"><?php echo Html::a('Indicador',Yii::$app->request->baseUrl.'/metrica/index'); ?></li>
	 <li role="presentation" class="<?= $macroactividad ?>"><?php echo Html::a('Macroactivad',Yii::$app->request->baseUrl.'/macroactividad/index'); ?></li>
	 <li role="presentation" class="<?= $microactividad ?>"><?php echo Html::a('Microactivad',Yii::$app->request->baseUrl.'/microactividad/index'); ?></li>
	 <li role="presentation" class="<?= $formato ?>"><?php echo Html::a('Métrica',Yii::$app->request->baseUrl.'/formato/index'); ?></li>
      
   </ul>
     
   </div>
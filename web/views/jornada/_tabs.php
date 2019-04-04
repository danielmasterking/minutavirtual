<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$empresa = isset($empresa) ? $empresa : '';
$servicio = isset($servicio) ? $servicio : '';
$codigo = isset($codigo) ? $codigo : '';
$puesto = isset($puesto) ? $puesto : '';
$jornada = isset($jornada) ? $jornada : '';
$dia = isset($dia) ? $dia : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $empresa ?>"><?php echo Html::a('Empresa',Yii::$app->request->baseUrl.'/empresa/create'); ?></li>
     <li role="presentation" class="<?= $servicio ?>"><?php echo Html::a('Servicio',Yii::$app->request->baseUrl.'/servicio/create'); ?></li>
     <li role="presentation" class="<?= $codigo ?>"><?php echo Html::a('Código Servicios',Yii::$app->request->baseUrl.'/detalle-servicio/create'); ?></li>
     <li role="presentation" class="<?= $puesto ?>"><?php echo Html::a('Puestos',Yii::$app->request->baseUrl.'/puesto/create'); ?></li>	 
	 <li role="presentation" class="<?= $jornada ?>"><?php echo Html::a('Jornada',Yii::$app->request->baseUrl.'/jornada/create'); ?></li>
     <li role="presentation" class="<?= $dia ?>"><?php echo Html::a('Días',Yii::$app->request->baseUrl.'/dia/create'); ?></li>	 
   </ul>
     
   </div>
<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$capacitacion = isset($capacitacion) ? $capacitacion : '';
$siniestro = isset($siniestro) ? $siniestro : '';
$visita = isset($visita) ? $visita : '';
$comite = isset($comite) ? $comite : '';
$informacion = isset($informacion) ? $informacion : '';
$prefacturas = isset($prefacturas) ? $prefacturas : '';

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 <li role="presentation" class="<?= $informacion ?>"><?php echo Html::a('Información',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$codigo_dependencia); ?></li>
     <li role="presentation" class="<?= $capacitacion ?>"><?php echo Html::a('Capacitaciones',Yii::$app->request->baseUrl.'/centro-costo/capacitacion?id='.$codigo_dependencia); ?></li>
     <li role="presentation" class="<?= $siniestro ?>"><?php echo Html::a('Siniestros',Yii::$app->request->baseUrl.'/centro-costo/siniestro?id='.$codigo_dependencia); ?></li>
     <li role="presentation" class="<?= $visita ?>"><?php echo Html::a('Visitas',Yii::$app->request->baseUrl.'/centro-costo/visita?id='.$codigo_dependencia); ?></li>
	 <li role="presentation" class="<?= $comite ?>"><?php echo Html::a('Comités',Yii::$app->request->baseUrl.'/centro-costo/comite?id='.$codigo_dependencia); ?></li>
     
   </ul>
     
   </div>
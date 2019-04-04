<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$capacitaciones = isset($capacitaciones) ? $capacitaciones : '';
$comites = isset($comites) ? $comites : '';
$visitas = isset($visitas) ? $visitas : '';
$investigaciones = isset($investigaciones) ? $investigaciones : '';
$siniestros = isset($siniestros) ? $siniestros : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
     <li role="presentation" class="<?= $capacitaciones ?>"><?php echo Html::a('Capacitaciones',Yii::$app->request->baseUrl.'/usuario/capacitacion?id='.$usuario); ?></li>
	 <li role="presentation" class="<?= $comites ?>"><?php echo Html::a('Comités',Yii::$app->request->baseUrl.'/usuario/comite?id='.$usuario); ?></li>
     <!--<li role="presentation" class="<?= $siniestros ?>"><?php //echo Html::a('Siniestros',Yii::$app->request->baseUrl.'/usuario/siniestro?id='.$usuario); ?></li>-->
	 <li role="presentation" class="<?= $visitas ?>"><?php echo Html::a('Visitas',Yii::$app->request->baseUrl.'/usuario/visita?id='.$usuario); ?></li>
	 <li role="presentation" class="<?= $investigaciones ?>"><?php echo Html::a('Investigaciones',Yii::$app->request->baseUrl.'/usuario/incidente?id='.$usuario); ?></li>

     
   </ul>
     
   </div>
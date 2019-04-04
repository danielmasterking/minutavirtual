<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$empresa = isset($empresa) ? $empresa : '';
$alarma = isset($alarma) ? $alarma : '';
$marca_alarma = isset($marca_alarma) ? $marca_alarma : '';
$desc_alarma=isset($desc_alarma) ? $desc_alarma : '';
$sistema_mon=isset($sistema_mon) ? $sistema_mon : '';
$precios_mon=isset($precios_mon) ? $precios_mon : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 
 	 
     <li role="presentation" class="<?= $alarma ?>"><?php echo Html::a('Tipo Alarma',Yii::$app->request->baseUrl.'/tipo-alarma/create'); ?></li>
     <!-- <li role="presentation" class="<?= $empresa ?>"><?php //echo Html::a('Precios',Yii::$app->request->baseUrl.'/empresa-precio/create'); ?></li> -->

     <li role="presentation" class="<?= $desc_alarma ?>"><?php echo Html::a('Descripcion alarmas',Yii::$app->request->baseUrl.'/descalarma/create'); ?></li>

     <li role="presentation" class="<?= $marca_alarma ?>"><?php echo Html::a('Marca alarmas',Yii::$app->request->baseUrl.'/marcaalarma/create'); ?></li>


     <li role="presentation" class="<?= $tipo_serv_elect ?>"><?php echo Html::a('Servicio',Yii::$app->request->baseUrl.'/tiposervicioelectronica/create'); ?></li>

      <li role="presentation" class="<?= $sistema_mon ?>"><?php echo Html::a('Sistema Monitoreado',Yii::$app->request->baseUrl.'/sistemamonitoreado/create'); ?></li>

      <li role="presentation" class="<?= $precios_mon ?>"><?php echo Html::a('Precios Monitoreado',Yii::$app->request->baseUrl.'/preciosmonitoreo/create'); ?></li>


	 </ul>
     
   </div>
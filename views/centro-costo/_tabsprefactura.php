<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$permisos = null;

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


use yii\helpers\Html;
$fija = isset($fija) ? $fija : '';
$electronica = isset($electronica) ? $electronica : '';


//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">

     <li role="presentation" class="<?= $fija ?>"><?php echo Html::a('Prefactura-fija',Yii::$app->request->baseUrl.'/centro-costo/prefacturas?id='.$codigo_dependencia); ?></li>  

     <li role="presentation" class="<?= $electronica ?>"><?php echo Html::a('Prefactura-electronica',Yii::$app->request->baseUrl.'/centro-costo/prefacturaselectronica?id='.$codigo_dependencia); ?></li>       
   </ul>
     
   </div>
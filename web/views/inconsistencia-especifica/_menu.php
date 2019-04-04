<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$permisos = array();

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

//$this->title = 'Exito';
?>
<div class="col-md-3">
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
      
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>  

 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
   <ul class="nav nav-pills nav-stacked">
   <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/inicio');?></li>
   <li ><?php echo Html::a('<i class="fa fa-building-o fa-fw"></i>Dependencias',Yii::$app->request->baseUrl.'/centro-costo/index');?></li>
	<?php if(in_array("administrador", $permisos) || in_array("coordinador", $permisos)):?>
	
	  <li><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Coordinadores',Yii::$app->request->baseUrl.'/usuario/cordinadores');?></li>
	
	<?php endif;?>
	<?php if(in_array("capacitacion", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-graduation-cap fa-fw"></i>Capacitación',Yii::$app->request->baseUrl.'/capacitacion/create');?></li>
	  
	<?php endif;?>
	
		<?php if(in_array("comite", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Comite',Yii::$app->request->baseUrl.'/comite/create');?></li>
	  
	<?php endif;?>
	
	<?php if(in_array("siniestro", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-wheelchair-alt fa-fw"></i>Siniestro',Yii::$app->request->baseUrl.'/siniestro/create');?></li>
	  
	<?php endif;?>
	
	<?php if(in_array("visita", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-suitcase fa-fw"></i>Visitas',Yii::$app->request->baseUrl.'/visita-dia/create');?></li>
	  
	<?php endif;?>	
	
	<?php if(in_array("investigacion", $permisos)):?>
	  
	  <li><?php echo Html::a('<i class="fa fa-search fa-fw"></i>Investigaciones',Yii::$app->request->baseUrl.'/incidente/create');?></li>
	  
	<?php endif;?>	
	
	<?php if(in_array("pedido", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-shopping-cart fa-fw"></i>Pedidos',Yii::$app->request->baseUrl.'/pedido/create');?></li>
	  
	<?php endif;?>
	
	<?php if(in_array("revision-pedido", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-check-square-o fa-fw"></i>Revisión Pedidos',Yii::$app->request->baseUrl.'/pedido/revision');?></li>
	  
	<?php endif;?>	
	
	<?php if(in_array("revision-tecnica", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-cog fa-fw"></i>Revisión Técnica',Yii::$app->request->baseUrl.'/pedido/revision-tecnica');?></li>
	  
	<?php endif;?>
	
	<?php if(in_array("revision-financiera", $permisos)):?>
	  
	  <li ><?php echo Html::a('<i class="fa fa-money fa-fw"></i>Revisión Financiera',Yii::$app->request->baseUrl.'/pedido/revision-financiera');?></li>
	  
	<?php endif;?>		
	
	<?php if(in_array("administrador", $permisos)):?>
	   <li ><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Roles',Yii::$app->request->baseUrl.'/rol/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Permisos',Yii::$app->request->baseUrl.'/permiso/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Regionales',Yii::$app->request->baseUrl.'/zona/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Distritos',Yii::$app->request->baseUrl.'/distrito/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Area Dependencia',Yii::$app->request->baseUrl.'/area-dependencia/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Zona Dependencia',Yii::$app->request->baseUrl.'/zona-dependencia/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Categoria',Yii::$app->request->baseUrl.'/categoria-visita/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Resultados',Yii::$app->request->baseUrl.'/resultado/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Novedad Categoria',Yii::$app->request->baseUrl.'/novedad-categoria-visita/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Valores Novedades',Yii::$app->request->baseUrl.'/valor-novedad/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-commenting-o fa-fw"></i>Mensaje Novedades',Yii::$app->request->baseUrl.'/mensaje-novedad/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Marcas',Yii::$app->request->baseUrl.'/marca/index');?></li>
	   <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Novedades',Yii::$app->request->baseUrl.'/novedad/index');?></li>
      
      <li class="active"><?php echo Html::a('<i class="fa fa-wrench fa-fw"></i>Maestras',Yii::$app->request->baseUrl.'/proveedor/index');?></li>  
	  <li ><?php echo Html::a('<i class="fa fa-pie-chart fa-fw"></i>indicadores',Yii::$app->request->baseUrl.'/indicador/index');?></li>
	<?php endif;?>
	 <li ><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>
   </ul>	

    </div>
  </div>
</nav>

</div>  
<div class="col-md-3">

</div>  
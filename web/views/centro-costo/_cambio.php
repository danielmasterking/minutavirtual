<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

//$this->title = 'Exito';
?>
<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cambio-clave">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>  
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div id="cambio-clave"class="collapse navbar-collapse navbar-ex1-collapse">

 
    <ul class="nav navbar-nav navbar-right">


      <?php if(isset(Yii::$app->session['usuario-exito'])):?>
        <li>
             <?php
                
                echo Html::a('<i class="fa fa-lock"></i> Cambiar Clave',Yii::$app->request->baseUrl.'/site/cambio');
               

             ?>
        </li>
        <li><a href="#"> Bienvenido, <strong><?= Yii::$app->session['usuario-exito']?></strong></a></li>
      <?php endif;?>
      
    </ul>
  </div>
</nav>
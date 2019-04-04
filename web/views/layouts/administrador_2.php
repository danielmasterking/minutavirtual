<?php

/* @var $this \yii\web\View */
/* @var $content string */
//Establecer zona horaria en colombia
date_default_timezone_set ( 'America/Bogota');

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  
	  <?= Html::a('Grupo Exito',Yii::$app->request->baseUrl.'/site/inicio',['class' => 'navbar-brand']) ?>
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
	  
	    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
          <ul class="dropdown-menu">
			
			<li><?php echo Html::a('Roles',Yii::$app->request->baseUrl.'/rol/index');?></li>
			<li><?php echo Html::a('Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
			
          </ul>
        </li>
      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Parametros <span class="caret"></span></a>
          <ul class="dropdown-menu">
		    <li><?php echo Html::a('Zonas',Yii::$app->request->baseUrl.'/zona/index');?></li>
			<li><?php echo Html::a('Novedades',Yii::$app->request->baseUrl.'/novedad/index');?></li>
			<li><?php echo Html::a('Marcas',Yii::$app->request->baseUrl.'/marca/index');?></li>
			<li><?php echo Html::a('Dependencia',Yii::$app->request->baseUrl.'/centro-costo/index');?></li>
          </ul>
        </li>
		
		<li><?php echo Html::a('Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>
		
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    <div class="container">

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Grupo Exito <?= date('Y') ?> Todos los derechos reservados</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php

if (Yii::$app->session->isActive){
    //$this->redirect(['site/index','flash' => 'La sessión actual ha terminado por favor ingrese nuevamente.']);
}
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
            <header >
               <!--<img class="img-responsive" style="width: 100%;height: 50%;" src="<?php //Yii::$app->request->baseUrl.'/img/EXITOPORTADA.png'?>">-->
            </header>
            <?php if(isset(Yii::$app->session['usuario-exito'])){ ?>
            <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
                <div class="container-fluid">
                    <div class="navbar-header nav-negro">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="nav-brand-negro" href="#">SGS Grupo Exito</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if(isset(Yii::$app->session['usuario-exito'])):?>
                                <li>
                                     <?php
                                        echo Html::a('<i class="fa fa-sign-out fa-fw"></i> Salir',Yii::$app->request->baseUrl.'/site/logout');
                                     ?>
                                </li>
                                <li>
                                     <?php
                                        echo Html::a('<i class="fa fa-lock"></i> Cambiar Clave',Yii::$app->request->baseUrl.'/site/cambio');
                                     ?>
                                </li>
                                <li><a href="#"> Bienvenido, <strong><?= Yii::$app->session['usuario-exito']?></strong></a></li>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Grupo Exito <?= date('Y') ?> Todos los derechos reservados. Cualquier inquietud, duda o necesidad particular ponerse en contacto con DannyMiguel.GuevaraBuiles@grupo-exito.com</p>
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

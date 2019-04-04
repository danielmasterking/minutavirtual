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
    <title>Grupo Exito</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

  <head></head>


    <div class="container">
      
        <?= $content ?>
		
    </div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Grupo Exito <?= date('Y') ?> todos los derechos reservados</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

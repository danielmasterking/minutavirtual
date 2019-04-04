<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Formulario de comité';
?>

<?= $this->render('_cambio') ?>

<div class="container" style="margin-top:5px;padding-top:5px;">

<div class="row">

<?= $this->render('_menu') ?>

<div class="col-md-10">

 <?= $this->render('_tabs',['nuevo' => $nuevo]) ?>
<?php if(isset($done) && $done === '200'):?>
   
   <p class="alert alert-success">Comité creado de forma correcta.</p>
   
<?php endif;?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'novedades' => $novedades,
		'marcas' => $marcas,
		'distritos' => $distritos,
		'dependencias' => $dependencias,
		'marcasUsuario' => $marcasUsuario,
		'distritosUsuario' => $distritosUsuario,
		'zonasUsuario' => $zonasUsuario,		
		'cordinadores' => $cordinadores,
    ]) ?>

</div>

</div>

</div>




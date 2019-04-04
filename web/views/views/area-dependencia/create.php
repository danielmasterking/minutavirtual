<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Area Dependencia';
?>

<?= $this->render('_cambio') ?>

<div class="container" style="margin-top:5px;padding-top:5px;">

<div class="row">

<?= $this->render('_menu') ?>

<div class="col-md-9">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>



</div>

</div>




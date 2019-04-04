<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DescAlarma */

$this->title = 'Actualizar Descripcion Alarma: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Desc Alarmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="desc-alarma-update">
   <?= $this->render('_tabs',['desc_alarma' => $desc_alarma ]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alarmas'=>$alarmas,
        'actualizar' => 's',
    ]) ?>

</div>

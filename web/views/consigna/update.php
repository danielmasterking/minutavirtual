<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consigna */

$this->title = 'Update Consigna: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Consignas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consigna-update">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

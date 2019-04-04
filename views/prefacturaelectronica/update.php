<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PrefacturaElectronica */

$this->title = 'Update Prefactura Electronica: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prefactura Electronicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prefactura-electronica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

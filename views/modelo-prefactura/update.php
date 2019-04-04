<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloPrefactura */

$this->title = 'Update Modelo Prefactura: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Modelo Prefacturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modelo-prefactura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

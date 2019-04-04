<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HelpRespuestas */

$this->title = 'Update Help Respuestas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Help Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="help-respuestas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

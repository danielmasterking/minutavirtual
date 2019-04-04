<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RespuestasGestion */

$this->title = 'Create Respuestas Gestion';
$this->params['breadcrumbs'][] = ['label' => 'Respuestas Gestions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuestas-gestion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

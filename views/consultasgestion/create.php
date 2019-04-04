<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ConsultasGestion */

$this->title = 'Create Consultas Gestion';
$this->params['breadcrumbs'][] = ['label' => 'Consultas Gestions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultas-gestion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

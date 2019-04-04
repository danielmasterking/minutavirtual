<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GestionRiesgo */

$this->title = 'Create Gestion Riesgo';
$this->params['breadcrumbs'][] = ['label' => 'Gestion Riesgos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gestion-riesgo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

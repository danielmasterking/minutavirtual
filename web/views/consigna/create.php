<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Consigna */

$this->title = 'Create Consigna';
$this->params['breadcrumbs'][] = ['label' => 'Consignas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consigna-create">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

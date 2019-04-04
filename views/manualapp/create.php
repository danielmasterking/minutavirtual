<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ManualApp */

$this->title = 'Create Manual App';
$this->params['breadcrumbs'][] = ['label' => 'Manual Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-app-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdminDependencia */

$this->title = 'Create Admin Dependencia';
$this->params['breadcrumbs'][] = ['label' => 'Admin Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-dependencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ModeloPrefactura */

$this->title = 'Create Modelo Prefactura';
$this->params['breadcrumbs'][] = ['label' => 'Modelo Prefacturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-prefactura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

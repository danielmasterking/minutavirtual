<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalle Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-servicio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Detalle Servicio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'servicio_id',
            'codigo',
            'descripcion',
            'precio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

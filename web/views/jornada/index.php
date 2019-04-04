<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jornadas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jornada-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jornada', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'hora_inicio',
            'hora_fin',
            'nocturna',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

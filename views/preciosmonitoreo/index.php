<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PreciosMonitoreoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Precios Monitoreos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precios-monitoreo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Precios Monitoreo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_empresa',
            'id_sistema_monitoreo',
            'valor_unitario',
            'ano',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

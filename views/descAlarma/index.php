<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DescAlarmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Desc Alarmas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desc-alarma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Desc Alarma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',
            'id_tipo_alarma',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ManualAppSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manual Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-app-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Manual App', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'modulo',
            'archivo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GestionRiesgoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestion Riesgos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gestion-riesgo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gestion Riesgo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_centro_costo',
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

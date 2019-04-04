<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inconsistencia Marcas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inconsistencia-marca-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Inconsistencia Marca', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'marca_id',
            'material',
            'descripcion',
            'maestra_proveedor_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

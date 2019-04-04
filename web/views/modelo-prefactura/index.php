<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modelo Prefacturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-prefactura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Modelo Prefactura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'puesto_id',
            'detalle_servicio_id',
            'cantidad_servicios',
            'horas',
            // 'lunes',
            // 'martes',
            // 'miercoles',
            // 'jueves',
            // 'viernes',
            // 'sabado',
            // 'domingo',
            // 'festivo',
            // 'hora_inicio',
            // 'hora_fin',
            // 'porcentaje',
            // 'ftes',
            // 'total_dias',
            // 'valor_mes',
            // 'centro_costo_codigo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

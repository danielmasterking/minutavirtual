<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloPrefactura */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Modelo Prefacturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-prefactura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'puesto_id',
            'detalle_servicio_id',
            'cantidad_servicios',
            'horas',
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado',
            'domingo',
            'festivo',
            'hora_inicio',
            'hora_fin',
            'porcentaje',
            'ftes',
            'total_dias',
            'valor_mes',
            'centro_costo_codigo',
        ],
    ]) ?>

</div>

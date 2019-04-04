<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Persona', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cedula',
            'nombres',
            'apellidos',
            [
                'class' => 'yii\grid\DataColumn',
                'label'=>'Estado',
                'value' => function ($data) {
                    return $data->estado=='A'?'Activo':'Inactivo'; 
                },
            ],
            //'sexo',
            //'telefono',
            //'celular',
             //'email:email',
            // 'estado',
            // 'observacion:ntext',

            ['class' => 'yii\grid\ActionColumn','template' => ' {update} {delete}'],
        ],
    ]); ?>
</div>

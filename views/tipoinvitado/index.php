<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoInvitadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo Invitados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-invitado-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Tipo Invitado', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            [   
                //'class' => DataColumn::className(),
                'label'=>'Empresa',
                'attribute' => 'empresa.nombre',
                'format' => 'text'
                // ...
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>

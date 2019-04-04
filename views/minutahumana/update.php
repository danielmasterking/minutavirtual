<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MinutaHumana */

$this->title = 'Update Minuta Humana: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Minuta Humanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="minuta-humana-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_inv'=>$list_inv,
	    'list_obs'=>$list_obs,
	    'empresas'=>$empresas,
	    
    ]) ?>

</div>

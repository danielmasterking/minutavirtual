<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PuestosDependencia */

$this->title = 'Update Puestos Dependencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Puestos Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="puestos-dependencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'zonas' => $zonas,
        'dependencias' => $dependencias,
        'empresas' => $empresas,
        'zonasUsuario' => $zonasUsuario,
        //'marcasUsuario' => $marcasUsuario,
        'distritosUsuario' => $distritosUsuario,                
        'empresasUsuario' => $empresasUsuario
    ]) ?>

</div>

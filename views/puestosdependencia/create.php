<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PuestosDependencia */

$this->title = 'Create Puestos Dependencia';
$this->params['breadcrumbs'][] = ['label' => 'Puestos Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puestos-dependencia-create">

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

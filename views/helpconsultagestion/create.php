<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HelpConsultaGestion */

$this->title = 'Create Help Consulta Gestion';
$this->params['breadcrumbs'][] = ['label' => 'Help Consulta Gestions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-consulta-gestion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

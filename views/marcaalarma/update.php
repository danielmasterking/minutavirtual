<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MarcaAlarma */

$this->title = 'Update Marca Alarma: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Marca Alarmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="marca-alarma-update">
	<?= $this->render('_tabs',['marca_alarma' => $marca_alarma ]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actualizar' => 's',
    ]) ?>

</div>

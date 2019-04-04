<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Inconsistencia';
?>
<?= $this->render('_tabsTecnica',['inconsistencia' => $inconsistencia]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'inconsistencias' => $inconsistencias,
		'maestras' => $maestras,
    ]) ?>
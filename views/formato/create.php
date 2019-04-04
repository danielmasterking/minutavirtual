<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Métrica ';
?>
<?= $this->render('_tabs',['formato' => $formato]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'microactividades' => $microactividades,
		'novedades' => $novedades,
    ]) ?>
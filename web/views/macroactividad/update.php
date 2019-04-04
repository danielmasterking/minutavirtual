<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Actualizar Macroactividad';
?>
<?= $this->render('_tabs',['macroactividad' => $macroactividad]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'metricas' => $metricas,
    ]) ?>
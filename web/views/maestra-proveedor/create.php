<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Maestra Proveedor';


?>
<?= $this->render('_tabs',['maestra' => $maestra]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'proveedores' => $proveedores,
		'marcas' => $marcas,
		'zonas' => $zonas,
    ]) ?>
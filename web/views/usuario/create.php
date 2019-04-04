<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Usuario';
?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
                'model' => $model,
				'roles' => $roles,
				'distritos' => $distritos,
				'marcas' => $marcas,
				'ciudades' => $ciudades,
				'zonas' => $zonas,
				'empresas' => $empresas,
    ]) ?>
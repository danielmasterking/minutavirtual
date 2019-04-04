<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Actualizar Usuario: '.$model->usuario;
?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
                'model' => $model,
				'roles' => $roles,
				'roles_actuales' => $roles_actuales,
				'zonas' => $zonas,
				'distritos' => $distritos,
				'marcas' => $marcas,
				'marcas_actuales' => $marcas_actuales,
				'zonas_actuales' => $zonas_actuales,
				'distritos_actuales' => $distritos_actuales,
				'empresas_actuales' => $empresas_actuales,
				'empresas' => $empresas,
    ]) ?>
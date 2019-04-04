<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TipoObservacion */

$this->title = 'Update Tipo Observacion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Observacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-observacion-update">

	<a href="<?php echo Url::toRoute('tipoobservacion/index')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver 
    </a>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_empresas'=>$list_empresas
    ]) ?>

</div>

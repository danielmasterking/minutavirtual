<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TipoInvitado */

$this->title = 'Update Tipo Invitado: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Invitados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-invitado-update">

	<a href="<?php echo Url::toRoute('tipoinvitado/index')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver 
    </a>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_empresas'=>$list_empresas
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Update Personas: ' . $model->cedula;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cedula, 'url' => ['view', 'id' => $model->cedula]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="personas-update">

	<a href="<?php echo Url::toRoute('personas/index')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver 
    </a>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

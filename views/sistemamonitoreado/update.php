<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SistemaMonitoreado */

$this->title = 'Actualizar Sistema Monitoreado: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Sistema Monitoreados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sistema-monitoreado-update">
<?= $this->render('_tabs',['sistema_mon' => 'active' ]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php 

        $flashMessages = Yii::$app->session->getAllFlashes();
        if ($flashMessages) {
            foreach($flashMessages as $key => $message) {
                echo "<div class='alert alert-" . $key . " alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        $message
                    </div>";   
            }
        }
    ?>
    <?= $this->render('_form', [
        'model' => $model,
        'actualizar'=>'S'

    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoServicioElectronica */

$this->title = 'Crear  Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Servicio Electronicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-servicio-electronica-create">
<?= $this->render('_tabs',['tipo_serv_elect' => $tipo_serv_elect ]) ?>
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
        'servicios'=>$servicios
    ]) ?>

</div>

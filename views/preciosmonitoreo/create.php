<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreciosMonitoreo */

$this->title = 'Crear Precios Monitoreo';
$this->params['breadcrumbs'][] = ['label' => 'Precios Monitoreos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precios-monitoreo-create">
<?= $this->render('_tabs',['precios_mon' => 'active' ]) ?>
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
        'empresas'=>$empresas,
        'sistema_monitoreado'=>$sistema_monitoreado,
        'consulta'=>$consulta
    ]) ?>

</div>

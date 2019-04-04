<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MarcaAlarma */

$this->title = 'Crear Marca Alarma';
$this->params['breadcrumbs'][] = ['label' => 'Marca Alarmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marca-alarma-create">
	<?= $this->render('_tabs',['marca_alarma' => $marca_alarma ]) ?>
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
        'marca_alarmas'=>$marca_alarmas
    ]) ?>

</div>

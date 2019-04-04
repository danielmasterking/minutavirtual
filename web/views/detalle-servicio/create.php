<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Crear Código Servicio';	

?>
      <?= $this->render('_tabs',['codigo' => $codigo]) ?>

   
   <?php if(isset($done) && $done === '200'):?>
   
         <p style="text-align: center;" class="alert alert-success">Código Servicio Creado.</p>
   
   <?php endif;?>
   

   
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'codigos' => $codigos,
		'servicios' => $servicios,

	
    ]) ?>
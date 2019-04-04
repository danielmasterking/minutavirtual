<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Actualizar Empresa';	

?>
      <?= $this->render('_tabs',['empresa' => $empresa]) ?>

   
   <?php if(isset($done) && $done === '200'):?>
   
     <p style="text-align: center;" class="alert alert-success">Empresa Actualizada</p>
   
   <?php endif;?>
   

   
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'empresas' => $empresas,
		'actualizar' => 's',
	
    ]) ?>
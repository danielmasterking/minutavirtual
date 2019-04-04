<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Asignación de presupuesto';	

?>
      <?= $this->render('_tabsFinanciera',['presupuesto' => $presupuesto]) ?>

   
   <?php if(isset($done) && $done === '200'):?>
   
     <p style="text-align: center;" class="alert alert-success">Presupuesto Asignado de forma correcta.</p>
   
   <?php endif;?>
   
  <?php if(isset($done) && $done === '500'):?>

 <p style="text-align: center;" class="alert alert-danger">Dependencia tiene presupuesto inicial asignado.</p>

<?php endif;?>
   
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
		'dependencias' => $dependencias,
		'presupuestos' => $presupuestos,
		'llaves' => $llaves,
	
    ]) ?>
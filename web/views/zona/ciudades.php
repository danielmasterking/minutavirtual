<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */


$data = array();
foreach ($ciudades as  $value) {
  
  $data[$value->codigo_dane] = $value->nombre;
}


?>
	  <div class="preaviso-form check-form">


<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

   <div class="row">

 <h3 class="col-md-5 ">Asignar ciudades a zona: <?=$zona->nombre ?></h3>
 
<p class="pull-right">&nbsp;</p>
 <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary pull-right','name'=>'asignar']) ?>
 


  
</div>
   

   <div class="form-group">
     <?php   
		 echo Select2::widget([
		'name' => 'ciudades',
		'data' => $data,
		'options' => [
			'placeholder' => 'Seleccionar ciudades',
			'multiple' => true
		],
	   ]);
     ?>   
   </div>

   <table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

   <thead>
     
     <tr>
       
       <th>Código</th>
       <th>Ciudad</th>
       <th></th>
     </tr>
   </thead>

   <tbody>

   <?php foreach($ciudades_asignadas as $key):?>

      <tr>
        
        <td><?= $key->ciudad_codigo_dane?></td>
        <td><?= $key->ciudad->nombre?></td>
        <td><?php
         
            echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/zona/delete-ciudad?id='.$key->zona_id.'&codigo_dane='.$key->ciudad_codigo_dane);

            ?>
         </td>

      </tr>

   <?php endforeach;?>
     

   </tbody>
     


   </table>
   


<?php ActiveForm::end(); ?>
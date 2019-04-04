<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */


$data = array();
foreach ($microactividades as  $value) {
  
  $data[$value->id] = $value->nombre;
}


?>
	  <div class="preaviso-form check-form">


<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

   <div class="row">

 <h3 class="col-md-5 ">Asignar Microactividades a usuario: <?=$usuario->nombres.' '.$usuario->nombres ?></h3>
 
<p class="pull-right">&nbsp;</p>
<?= Html::a('Macroactividades',Yii::$app->request->baseUrl.'/usuario/actividades-macro?id='.$usuario->usuario,['class'=>'btn btn-primary']) ?>
 <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary pull-right','name'=>'asignar']) ?>
 


  
</div>
   

   <div class="form-group">
     <?php   
		 echo Select2::widget([
		'name' => 'microactividades-asi',
		'data' => $data,
		'options' => [
			'placeholder' => 'Seleccionar microactividades',
			'multiple' => true
		],
	   ]);
     ?>   
   </div>

   <table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

   <thead>
     
     <tr>
       
       
       <th>Microactividad</th>
       <th></th>
     </tr>
   </thead>

   <tbody>

   <?php foreach($microactividades_asignadas as $key):?>

      <tr>

        <td><?= $key->microactividad->nombre?></td>
        <td><?php
         
            echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/usuario/delete-micro?id='.$key->usuario.'&micro='.$key->microactividad_id);

            ?>
         </td>

      </tr>

   <?php endforeach;?>
     

   </tbody>
     


   </table>
   


<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Crear Novedad';
?>
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

<div class="row">

 <h3 class="col-md-5 ">Asignar Permisos a rol: <?=$rol->nombre ?></h3>
 <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary col-md-offset-5 col-xs-offset-5','name'=>'asignar']) ?>


  
</div>

  
   <table class="table">

   <thead>
     
     <tr>
       
       <th></th>
       <th>Permiso</th>
       
     </tr>
   </thead>

   <tbody>

   <?php foreach($permisos as $key):?>

      <tr>
        
        <td>
            <?php if(in_array($key->id, $permisos_actuales_array)):?>
              <?= Html::checkBox('permisos_array[]',true, ['value' => $key->id])?>
            <?php else:?>
              <?= Html::checkBox('permisos_array[]',false, ['value' => $key->id])?>
            <?php endif;?>
        </td>

        <td><?= $key->nombre?></td>
        



      </tr>


   <?php endforeach;?>
     

   </tbody>
     


   </table>
   


<?php ActiveForm::end(); ?>
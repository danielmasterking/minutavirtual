<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop ;
use yii\helpers\Url;


$data_maestras = array();
foreach ($maestras as $value) {
    
    $data_maestras[$value->id] = $value->proveedor->nombre.'-'.$value->zona->nombre;
}

/* @var $this yii\web\View */
/* @var $model app\models\InconsistenciaGeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inconsistencia-general-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
	<?= Html::a('Aprobación Anticipada Marca',Yii::$app->request->baseUrl.'/inconsistencia-marca/create',['class'=>'btn btn-primary']) ?>
	<?= Html::a('Aprobación Anticipada Maestra',Yii::$app->request->baseUrl.'/inconsistencia-maestra/create',['class'=>'btn btn-primary']) ?>

    <p>&nbsp;</p>
     <?=

		   $form->field($model, 'maestra_proveedor_id')->widget(Select2::classname(), [
		   'options' => ['id' => 'maestra-select', 'placeholder' => 'Seleccione maestra'],
		   'data' => $data_maestras,
		
		  ])


	?>

	
	<p>&nbsp;</p>
	
	<?=


	   $form->field($model, 'material')->widget(DepDrop::classname(), [
		'options' => ['id' => 'material-1'],
		'type'=>DepDrop::TYPE_SELECT2,
		 'data' => [1 => ''],   
		'pluginOptions'=>[
		
			'depends'=>['maestra-select'],
			'placeholder' => 'Select...',
			'url'=>Url::to(['maestra-proveedor/listado']),
			//'params'=>['input-type-1', 'input-type-2']
		]
	  ])


	 ?>

	
	<?= $form->field($model,'descripcion')->textArea(['rows' => 6]); ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>
	
	


    <?php ActiveForm::end(); ?>
	
	
		<table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Proveedor</th>
		   <th>Material</th>
		   <td>Descripción</td>

		   
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($inconsistencias as $key):?>	  
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/inconsistencia-material/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento?']);

                    ?>
				</td>
                <td><?= $key->maestra->proveedor->nombre?></td>
				<td><?= $key->material?></td>
     			<td><?= $key->descripcion?></td>
				
				
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>

</div>

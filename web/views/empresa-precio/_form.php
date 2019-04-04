<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

/* @var $this yii\web\View */
/* @var $model app\models\EmpresaPrecio */
/* @var $form yii\widgets\ActiveForm */
$data_empresas = array();

foreach($empresas as $key){
	
	$data_empresas[$key->nit] = $key->nombre;	
	
}

$data_alarmas = array();
foreach($alarmas as $key){
	
	$data_alarmas[$key->id] = $key->nombre;	
	
}



?>

<div class="empresa-precio-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>
	
    <?= $form->field($model, 'nit')->dropDownList($data_empresas) ?>

    <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_alarma_id')->dropDownList($data_alarmas) ?>


    <?php ActiveForm::end(); ?>
	
	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Empresa</th>
				 <th>Servicio</th>
				 <th>Precio</th>


			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($precios as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/empresa-precio/update?id='.$key->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/empresa-precio/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
					?>
					</td>
					<td><?=$key->emp->nombre?></td>
					<td><?=$key->tipoAlarma->nombre?></td>
					<td><?=$key->precio?></td>

                   </tr>					


               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>		

</div>

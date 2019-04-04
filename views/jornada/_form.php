<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

/* @var $this yii\web\View */
/* @var $model app\models\Jornada */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jornada-form">
	<?php if( isset($actualizar) ):?>	
    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>	

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	
	<?=$form->field($model, 'hora_inicio')->widget(TimePicker::classname(), [
		'readonly'=>true,
		'pluginOptions' => [
	        'showSeconds' => true,
	        'showMeridian' => false,
	        'minuteStep' => 1,
	        'secondStep' => 5,
	    ]
	])?>

	<?=$form->field($model, 'hora_fin')->widget(TimePicker::classname(), [
		'readonly'=>true,
		'pluginOptions' => [
	        'showSeconds' => true,
	        'showMeridian' => false,
	        'minuteStep' => 1,
	        'secondStep' => 5,
	    ]
	])?>

	  <?= $form->field($model, 'nocturna')->dropDownList(['N' => 'NO', 
	                                                    'S' => 'SI',
														]) ?>	  

    <?php ActiveForm::end(); ?>
	<?php endif;?>	
	<?php if( !isset($actualizar) ):?>	
	
	<div class="col-md-12">
	 
	 <table class="table table-responsive">
	   
		   <thead>
		   
		      <tr>
			     <th></th>
			     <th>Nombre</th>
			     <th>Hora Inicio</th>
				 <th>Hora Fin</th>
				 <th>Nocturna</th>

			  
			  </tr>
		   
		   
		   </thead>
		   
		   <tbody>
		       
			   <?php foreach($jornadas as $key):?>
			   
		           <tr>
				   
				    <td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/jornada/update?id='.$key->id);
						  //echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/jornada/delete?id='.$key->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
						?>
					</td>
					<td><?=$key->nombre?></td>
					<td><?=$key->hora_inicio?></td>
					<td><?=$key->hora_fin?></td>
					<td><?=$key->nocturna?></td>

					</tr>					
               <?php endforeach;?>			   
	   
	 
	 </table>
	
	</div>
	
	<?php endif;?>	

</div>

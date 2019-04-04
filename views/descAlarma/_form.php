<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\DescAlarma */
/* @var $form yii\widgets\ActiveForm */
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}




?>

<div class="desc-alarma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'id_tipo_alarma')->widget(Select2::classname(), [
       
       'data' => $alarmas,
       'options' => ['placeholder' => 'Selecciona un tipo de alarma' ],
    
      ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php if( !isset($actualizar) ):?>
    <div class="col-md-12">
    	<table class="table table striped">
    		<thead>
    			<tr>
    				<th></th>	
    				<!-- <th>Id</th> -->
    				<th>Descripcion</th>
    				<th>Tipo alarma</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php 

    			foreach($desc_alarmas_all as $row):
    			?>
    			<tr>	
    				<td>
					
					<?php
					
					if($permisos != null){
										
						if(in_array("administrador", $permisos) ){
						   
						  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/descalarma/update?id='.$row->id);
						  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/descalarma/delete?id='.$row->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
		  
						 }
						 
					}
					?>
					</td>

    				<!-- <td><?php //echo $row->id ?></td> -->
    				<td><?= $row->descripcion ?></td>
    				<td><?= $row->alarma_tipo->nombre ?></td>
    			</tr>
    		<?php endforeach;?>
    		</tbody>
    	</table>
    </div>
    <?php endif;?>
</div>

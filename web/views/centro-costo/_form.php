<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\CentroCosto */
/* @var $form yii\widgets\ActiveForm */
$data_ciudades = array();

$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

foreach ($ciudades as $key) {
  
  $data_ciudades[$key->codigo_dane] = $key->nombre; 
}

$data_empresas = array();

foreach ($empresas as $key) {
  
  $data_empresas[$key->nit] = $key->nombre; 
}

$data_marcas = array();

foreach ($marcas as $key) {
  
  $data_marcas[$key->id] = $key->nombre; 
}

$distritos_permitidos = array();
foreach($distritosUsuario as $distrito){
	
     $distritos_permitidos [] = $distrito->distrito->id;	
	
}


$data_distritos = array();
foreach ($distritos as $value) {
    
	if(in_array($value->id,$distritos_permitidos)){
	  
      $data_distritos[$value->id] = $value->nombre;	  
	}
    
}



?>

<div class="centro-costo-form">

    <?php $form = ActiveForm::begin(); ?>
   
    <?php
	
	   if(in_array('administrador',$permisos) ){
		   
		   ?>
		   
            	<?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'cebe')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'ceco')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
		   <?php
		   
		   
	   }
	
	?>
   

	<?php if(!isset($actualizar)):?>
    
     <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>   
   <?php endif;?>
   

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'marca_id')->widget(Select2::classname(), [
       
	   'data' => $data_marcas,
    
      ])?>
	  
	<?= $form->field($model, 'ciudad_codigo_dane')->widget(Select2::classname(), [
       
	   'data' => $data_ciudades,
    
      ])?>

	<?= $form->field($model, 'empresa')->widget(Select2::classname(), [
       
	   'data' => $data_empresas,
	   'options' => ['placeholder' => 'Selecccione empresa'],
    
      ])?>	  
	  
	  		<?php
		
		   echo Select2::widget([
			'name' => 'distrito',
			'data' => $data_distritos,
			'options' => [
				'id' => 'distrito',
				'placeholder' => 'Distrito',
											
			 ],


		   ]);
		
	?>	
	<p>&nbsp;</p>

	
	<?php
       
          if(in_array('administrador',$permisos) ){
    ?>
	
	  <?= $form->field($model, 'estado')->dropDownList(['A' => 'Abierta', 
	                                                    'C' => 'Cerrada',
														'D' => 'En Desarrollo',
														'O' => 'Otro']) ?>	  


    <?php

		  }		  
	
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	

</div>

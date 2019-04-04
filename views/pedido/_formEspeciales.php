<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\FileInput;
use kartik\money\MaskMoney;
MaskMoney::widget([
    'name' => 'amount_drcr',
    'value' => 20322.22
]);
date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());

$ciudades_zonas = array();

foreach($zonasUsuario as $zonaO){
	
     $ciudades_zonas [] = $zonaO->zona->ciudades;	
	
}

$ciudades_permitidas = array();

foreach($ciudades_zonas as $ciudades){
	
	foreach($ciudades as $ciudad){
		
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		
	}
	
}

$marcas_permitidas = array();

foreach($marcasUsuario as $marca){
	
		
		$marcas_permitidas [] = $marca->marca_id;

}

$dependencias_distritos = array();

foreach($distritosUsuario as $distrito){
	
     $dependencias_distritos [] = $distrito->distrito->dependencias;	
	
}

$distritos_permitidos = array();
foreach($distritosUsuario as $distrito){
	
     $distritos_permitidos [] = $distrito->distrito->id;	
	
}



$dependencias_permitidas = array();

foreach($dependencias_distritos as $dependencias0){
	
	foreach($dependencias0 as $dependencia0){
		
		$dependencias_permitidas [] = $dependencia0->dependencia->codigo;
		
	}
	
}

$tamano_dependencias_permitidas = count($dependencias_permitidas);

$data_dependencias = array();

foreach($dependencias as $value){
	
	if(in_array($value->ciudad_codigo_dane,$ciudades_permitidas)){
		
		if(in_array($value->marca_id,$marcas_permitidas)){
			
		   if($tamano_dependencias_permitidas > 0){
			   
			   if(in_array($value->codigo,$dependencias_permitidas)){
				   
				 $data_dependencias[$value->codigo] =  $value->nombre;
				   
			   }else{
				   //temporal mientras se asocian distritos
				   $data_dependencias[$value->codigo] =  $value->nombre;
			   }
			   
			   
		   }else{
			   
			   $data_dependencias[$value->codigo] =  $value->nombre;
		   }	
       
		}

	}
}

$ids_zonas = array();

if(isset($zonas_actuales)){

    foreach ($zonas_actuales as $key => $value) {
        
		$ids_zonas [] = $value['zona_id'];
    }

}


/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pedido-form">

      <?php $form = ActiveForm::begin([
      	'id' => 'pedido-form',
        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

	
	
	 <div class="col-md-12">
	 
	     
       <?= $form->field($model, 'fecha')->textInput(['value' => $fecha,'readonly' => 'readonly']) ?>
	 
	 
	 </div>
	
	<?= Html::activeHiddenInput($model, 'solicitante',['value' => Yii::$app->session['usuario-exito'] ])?>	
	
	<div class="col-md-12">
	
	<?=
       $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
       
	   'data' => $data_dependencias,
    
      ])

     ?>
	<?php
		 // Usage with ActiveForm and model
		 echo $form->field($model, 'file')->widget(FileInput::classname(), [
		//'options' => ['accept' => 'image/*'],
		'pluginOptions'=>['allowedFileExtensions'=>['xls', 'xlsx', 'pdf','jpg','png','gif','jpeg'],
						   'maxFileSize' => 5120,
		  ]
		 ]);

	 ?>

    </div>
	
	<div class="col-md-12">

		<p>&nbsp;</p>
		  <button type="button" id="btn-add-producto-especial" class="btn btn-default btn-primary pull-right" aria-label="Left Align">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		  </button>

	</div>	
	<p>&nbsp;</p>
	
	<div class="col-md-12">
	
	   <div id="productos" class="col-md-12">
		   
	   </div>
	
	</div>

    <div class="col-md-12">
			
	  <input type="hidden" name="cantidad-productos" id="cantidad-productos" value="0"/>	
		
      <p>&nbsp;</p>
      
	  <div class="col-md-12">
	  
	    <?= $form->field($model, 'observaciones')->textArea(['rows' => 6]) ?>
	  
	  </div>
		
	  <div class="form-group">
	  	
         <?php //Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary btn-lg']) ?>
       </div>
			
	</div>

    <?php ActiveForm::end(); ?>
    <button class="btn btn-primary btn-lg" onclick="validarPedido();"><?= $model->isNewRecord ? 'Crear' : 'Actualizar'?></button>

    <?php /*Html::button($model->isNewRecord ? 'Crear' : 'Actualizar',
                    ['class'=>'btn btn-primary btn-lg',
                        'onclick'=>'validarPedido();',
                    ]
                );*/?>

</div>

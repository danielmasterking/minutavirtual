<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use marqu3s\summernote\Summernote;
use kartik\widgets\FileInput;

date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());

$data_novedades = array();
foreach ($novedades as $value) {
    
    $data_novedades[$value->id] = $value->nombre;
}

$data_marcas = array();
foreach ($marcas as $value) {
    
    $data_marcas[$value->id] = $value->nombre;
}



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


$data_distritos = array();
foreach ($distritos as $value) {
    
	if(in_array($value->id,$distritos_permitidos)){
	  
      $data_distritos[$value->id] = $value->nombre;	  
	}
    
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


$data_cordinadores = array();

foreach($cordinadores as $value){
	
	if($value->usuario !== 'admin' ){
		
	  $roles = $value->roles;

      foreach($roles as $rol){
		
		if($rol->rol_id === 2){
			
		  $data_cordinadores [] = array('usuario' => $value->usuario, 'nombre' => $value->nombres.' '.$value->apellidos);			
		}
		
        
		  
	  }	  
		
	  
	}
	
}

/* @var $this yii\web\View */
/* @var $model app\models\Comite */
/* @var $form yii\widgets\ActiveForm */
?>

<script>

    var cordinadores = <?php echo json_encode($data_cordinadores);?>;
	var len_cor = cordinadores.length;
	var index_cor = 1;

</script>

<div class="comite-form">

       <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>
	
    <div class="col-md-12">
	  <div class="col-md-12">
	   <?= $form->field($model, 'fecha')->textInput(['value' => $fecha,'readonly' => 'readonly']) ?>
	   </div>
	</div>

    <div class="col-md-12">
	  <div class="col-md-12">
	<?=

       $form->field($model, 'novedad_id')->widget(Select2::classname(), [
       
	   'data' => $data_novedades,
    
      ])
	  
	  


     ?>
	 
	 <div id="marca" class="form-group hidden">
	  
		<?php
			
			   echo Select2::widget([
				'name' => 'marca-cod',
				'data' => $data_distritos,
				'options' => [
					'id' => 'marca-cod',
					'placeholder' => 'Distrito',
												
				 ],


			   ]);
			
		?>	
	 </div>
	 
	 <div id="dependencia" class="form-group hidden">
	 
		<?php
			
			   echo Select2::widget([
				'name' => 'dependencia-cod',
				'data' => $data_dependencias,
				'options' => [
					'id' => 'dependencia-cod',
					'placeholder' => 'Dependencia',
												
				 ],


			   ]);
			
		?>		 
	 
	 </div>
	 
	 	<div id="add-cor" class="form-group hidden">
			
			  <div class="row">
			  		

			    <div class="col-md-12">

				<p>&nbsp;</p>
				  <button type="button" id="btn-add-cor" class="btn btn-default btn-primary pull-right" aria-label="Left Align">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"> Cordinador</span>
				  </button>


				</div>	

		        <div id="cordinadores" class="form-group">
		   
		        </div>				
			  
			  </div>

               

           </div>
	 
	 <?= $form->field($model, 'observaciones')->widget(Summernote::className(), [
		  
		    ]) ?>   
	 
	 	<?php
			 // Usage with ActiveForm and model
			 echo $form->field($model, 'image')->widget(FileInput::classname(), [
			//'options' => ['accept' => 'image/*'],
			'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg'],
							   'maxFileSize' => 5120,
			  ]
			 ]);

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
		
		<div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
        </div>
	 </div>   
	 </div>  
      
	  <input type="hidden" name="cantidad-cor" id="cantidad-cor" value="0"/>		
		<?= Html::activeHiddenInput($model, 'usuario',['value' => Yii::$app->session['usuario-exito'] ])?>	



    <?php ActiveForm::end(); ?>

</div>

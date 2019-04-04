<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
$this->title = 'Crear Pre-factura';
date_default_timezone_set ('America/Bogota');
$year = date('Y');
$regionales = array();
$ciudades_zonas = array();//almacena las regionales permitidas al usuario

foreach($zonasUsuario as $zona){
	$ciudades_zonas [] = $zona->zona->ciudades;
}
$ciudades_permitidas = array();
foreach($ciudades_zonas as $ciudades){
	foreach($ciudades as $ciudad){
		foreach($zonas as $z){
			if($z->id==$ciudad->zona_id){
				$regionales[$z->nombre] = $z->nombre;break;
			}
		}
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
	}
}
$marcas_permitidas = array();
$marcas = array();
foreach($marcasUsuario as $marca){
	$marcas_permitidas [] = $marca->marca_id;
	$marcas[$marca->marca->nombre] = $marca->marca->nombre;
}
$empresas_permitidas = array();
$data_empresas = array();
foreach($empresasUsuario as $empresa){
	$empresas_permitidas [] = $empresa->nit;
	$data_empresas[$empresa->nit] = $empresa->empresa->nombre; 
}
$data_dependencias = array();
foreach($dependencias as $dependencia){
	if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ){
		if(in_array($dependencia->marca_id,$marcas_permitidas) ){
			//if(in_array($dependencia->empresa,$empresas_permitidas) ){
				$data_dependencias[$dependencia->codigo] = $dependencia->nombre;
			//}
		}
	}
}
?>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?php if(isset($mensaje)){?>
	<div class="alert alert-warning alert-dismissable">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<strong>Advertencia!</strong> <?=$mensaje?>
	</div>
<?php } ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-4">
		<?= $form->field($model, 'mes')->dropDownList(['01' => 'ENERO', 
			'02' => 'FEBRERO',
			'03' => 'MARZO',
			'04' => 'ABRIL',
			'05' => 'MAYO',
			'06' => 'JUNIO',
			'07' => 'JULIO',
			'08' => 'AGOSTO',
			'09' => 'SEPTIEMBRE',
			'10' => 'OCTUBRE',
			'11' => 'NOVIEMBRE',
			'12' => 'DICIEMBRE',
		]) ?>
	</div>
	<div class="col-md-4">
		<?= $form->field($model, 'ano')->textInput(['value' => $year,'maxlength' => true,'readonly'  => 'readonly']) ?>
	</div>
	<div class="col-md-4">
		<?= $form->field($model, 'empresa')->widget(Select2::classname(), [
			'data' => $data_empresas,
			'options' => ['placeholder' => 'Selecccione Empresa'],
		])?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?= $form->field($model, 'centro_costo_codigo')->widget(Select2::classname(), [
			'data' => $data_dependencias,
			'options' => ['placeholder' => 'Selecccione Dependencia'],
		])?>
	</div>
</div>
<?= Html::submitButton('Generar', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
<script>
	var ciudad_zona = JSON.parse('<?php echo json_encode($ciudades_zonas_permitidas);?>');
	var dependencias = JSON.parse('<?php echo json_encode($data_dependencias);?>');
	$("#prefacturafija-regional").on('change',function(){
		var region= $(this).val();
		var ciudades = [];
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < ciudad_zona.length; index++ ) {
        	console.log("region id= "+region)
            if(ciudad_zona[index]['zona_nombre']==region){
            	ciudades.push( ciudad_zona[index] );
            }
        }
        $('#prefacturafija-ciudad').empty();
        for ( var i=0; i < ciudades.length; i++ ) {
            $('#prefacturafija-ciudad').append($('<option>', {
			    value: ciudades[i]['nombre'],
			    text: ciudades[i]['nombre']
			}));
        }
        $('#prefacturafija-marca').change();
   	});
   	$("#prefacturafija-ciudad").on('change',function(){
   		$('#prefacturafija-marca').change();
   	});
   	$("#prefacturafija-marca").on('change',function(){
		var marca= $(this).val();
		var ciudad= $('#prefacturafija-ciudad').val();
		var depencias = [];
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < dependencias.length; index++ ) {
        	//console.log("marca id= "+marca)
        	
        	if(dependencias[index]['nombre_ciudad']==ciudad){
        		console.log("depen= "+dependencias[index]['nombre']+", ciudad= "+dependencias[index]['nombre_ciudad']+", marca= "+dependencias[index]['nombre_marca'])
        	}
            if(dependencias[index]['nombre_marca']==marca && dependencias[index]['nombre_ciudad']==ciudad){
            	depencias.push( dependencias[index] );
            }
        }
        $('#prefacturafija-centro_costo_codigo').empty();
        for ( var i=0; i < depencias.length; i++ ) {
            $('#prefacturafija-centro_costo_codigo').append($('<option>', {
			    value: depencias[i]['codigo'],
			    text: depencias[i]['nombre']
			}));
        }
   	});
</script>
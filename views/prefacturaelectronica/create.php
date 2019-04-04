<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;


date_default_timezone_set ('America/Bogota');
$year = date('Y');
$regionales = array();
$ciudades_zonas = array();//almacena las regionales permitidas al usuario

foreach($zonasUsuario as $zona){
	$ciudades_zonas [] = $zona->zona->ciudades;
}


$ciudades_permitidas = array();
$ciudades_zonas_permitidas = array();//guarda solo la regional y la ciudad para filtrar por javascript
foreach($ciudades_zonas as $ciudades){
	foreach($ciudades as $ciudad){
		foreach($zonas as $z){
			if($z->id==$ciudad->zona_id){
				$regionales[$z->id] = $z->nombre;break;
			}
		}
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		$ciudades_zonas_permitidas [] = array('zona' => $ciudad->zona_id, 'nombre' => $ciudad->ciudad->nombre, 'codigo' => $ciudad->ciudad->codigo_dane);
	}
}
$marcas_permitidas = array();
$marcas = array();
foreach($marcasUsuario as $marca){
	$marcas_permitidas [] = $marca->marca_id;
	$marcas[$marca->marca->nombre] = $marca->marca->nombre;
}
$empresas_permitidas = array();
foreach($empresasUsuario as $empresa){
	$empresas_permitidas [] = $empresa->nit;
}

$data_dependencias = array();
foreach($dependencias as $dependencia){
	if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ){
		if(in_array($dependencia->marca_id,$marcas_permitidas) ){
			if(in_array($dependencia->empresa,$empresas_permitidas) ){
				$data_dependencias[] = array('codigo' => $dependencia->codigo, 'nombre' => $dependencia->nombre, 'codigo_ciudad' => $dependencia->ciudad_codigo_dane, 'codigo_marca' => $dependencia->marca_id);
			}
		}
	}
}




/* @var $this yii\web\View */
/* @var $model app\models\PrefacturaElectronica */

$this->title = 'Crear Prefactura Electronica';
$this->params['breadcrumbs'][] = ['label' => 'Prefactura Electronicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prefactura-electronica-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Pre-facturas',Yii::$app->request->baseUrl.'/prefacturaelectronica/index', ['class'=>'btn btn-primary']) ?>
    <?php /*echo $this->render('_form', [
        'model' => $model,
    ]) */?>
    <?php if(isset($mensaje)){?>
	<div class="alert alert-warning alert-dismissable">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<strong>Advertencia!</strong> <?=$mensaje?>
	</div>
    <?php } ?>


    <?php $form = ActiveForm::begin(); ?>
<br>
<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'mes')->dropDownList([
			'01' => 'ENERO', 
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
	<div class="col-md-6">
		<?= $form->field($model, 'ano')->textInput(['value' => $year,'maxlength' => true,'readonly'  => 'readonly']) ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'regional')->widget(Select2::classname(), [
			'data' => $regionales,
			'options' => ['placeholder' => 'Selecccione Regional'],
		])?>
	</div>
	<div class="col-md-6">
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
	$('#prefacturaelectronica-centro_costo_codigo').empty();
	$('#prefacturaelectronica-regional').val();
	$("#prefacturaelectronica-regional").on('change',function(){
		var region= $(this).val();
		var depencias=[];
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < ciudad_zona.length; index++ ) {
            if(ciudad_zona[index]['zona']==region){//elige la ciudad
            	for ( var i=0; i < dependencias.length; i++ ) {
		            if(dependencias[i]['codigo_ciudad']==ciudad_zona[index]['codigo']){//comprara ciduad con ciudad dependencia
		            	depencias.push( dependencias[i] );
		            }
            	}
        	}
	    }
	    $('#prefacturaelectronica-centro_costo_codigo').empty();
        for ( var i=0; i < depencias.length; i++ ) {
            $('#prefacturaelectronica-centro_costo_codigo').append($('<option>', {
			    value: depencias[i]['codigo'],
			    text: depencias[i]['nombre']
			}));
        }
   	});
</script>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());

$this->title = 'Historico de pedidos especiales';
$regionales = array();
$regionales['[Selecccione Region]'] = '[Selecccione Region]';
$ciudades_zonas = array();//almacena las regionales permitidas al usuario

foreach($zonasUsuario as $zona){
	$ciudades_zonas [] = $zona->zona->ciudades;
}
foreach($ciudades_zonas as $ciudades){
	foreach($ciudades as $ciudad){
		foreach($zonas as $z){
			if($z->id==$ciudad->zona_id){
				$regionales[$z->nombre] = $z->nombre;break;
			}
		}
	}
}
$marcas = array();
$marcas[0] =  'POR MARCA...';
foreach($marcasUsuario as $marca){
	$marcas[$marca->marca->nombre] =  $marca->marca->nombre;
}
$data_dependencias = array();
$data_dependencias[0] =  'POR DEPENDENCIA...';
foreach($dependencias as $value){
	$data_dependencias[$value->nombre] =  $value->nombre;
}
?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
   	<div class="col-md-12">
	   	<?= Html::a('Normales',Yii::$app->request->baseUrl.'/pedido/historico',['class'=>'btn btn-primary']) ?>
   	</div>
   	<form id="form_excel" method="post" action="<?php echo Url::toRoute('pedido/historico-especial')?>">
   		<div class="row">
	   		<div class="navbar-form navbar-right" role="search">
	   			<div class="form-group">
		   			<?php 
		  				echo Select2::widget([
		  					'id' => 'regional',
						    'name' => 'regional',
						    'value' => '',
						    'data' => $regionales,
						    'options' => ['multiple' => false, 'placeholder' => 'Selecccione Regional']
						]);
		  			?>
		   		</div>
		   		<div class="form-group">
		   			<?php 
		  				echo Select2::widget([
		  					'id' => 'marca',
						    'name' => 'marca',
						    'value' => '',
						    'data' => $marcas,
						    'options' => ['multiple' => false, 'placeholder' => 'Selecccione Marca']
						]);
		  			?>
		   		</div>
	   		</div>
	   	</div>
   		<!--<div class="navbar-form navbar-right" role="search">
	   		<div class="row">
		   		<div class="form-group">
		   			<?php 
		  				/*echo Select2::widget([
		  					'id' => 'regional',
						    'name' => 'regional',
						    'value' => '',
						    'data' => $regionales,
						    'options' => ['multiple' => false, 'placeholder' => 'Selecccione Regional']
						]);
		  			?>
		   		</div>
		   		<div class="form-group">
		   			<?php 
		  				echo Select2::widget([
		  					'id' => 'ciudad',
						    'name' => 'ciudad',
						    'value' => '',
						    'data' => null,
						    'options' => ['multiple' => false, 'placeholder' => 'Selecccione Ciudad']
						]);
		  			?>
		   		</div>
		   		<div class="form-group">
		   			<?php 
		  				echo Select2::widget([
		  					'id' => 'marca',
						    'name' => 'marca',
						    'value' => '',
						    'data' => $marcas,
						    'options' => ['multiple' => false, 'placeholder' => 'Selecccione Marca']
						]);*/
		  			?>
		   		</div>
	   		</div>
	   	</div>-->
	   	<div class="row">
	   		<div class="navbar-form navbar-right" role="search">
	   			<div class="form-group">
	   				<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar Coincidencias">
		   		</div>
			  	<div class="form-group">
		  			<?php 
		  				echo Select2::widget([
		  					'id' => 'dependencias2',
						    'name' => 'dependencias2',
						    'value' => '',
						    'data' => $data_dependencias,
						    'options' => ['multiple' => false, 'placeholder' => 'POR DEPENDENCIA...']
						]);
		  			?>
			  	</div>
			  	<div class="form-group">
			  		<select id="ordenado" name="ordenado" class="form-control">
			  			<option value="">[ORDENAR POR...]</option>
			  			<option value="fecha">Fecha</option>
			  			<option value="repetido">Repetido</option>
			  			<option value="dependencia">Dependencia</option>
			  			<option value="producto">Producto</option>
			  			<option value="cantidad">Cantidad</option>
			  			<option value="proveedor">Proveedor</option>
			  			<option value="orden">Orden Compra</option>
			  			<option value="solicitante">Solicitante</option>
			  			<option value="fcoordinador">Fecha Coordinador</option>
			  			<option value="ftecnica">Fecha Tecnica</option>
			  			<option value="ffinanciera">Fecha Financiera</option>
			  			<option value="ocoordinador">Obs.Coordinador</option>
			  			<option value="otecnica">Obs. Tecnica</option>
			  			<option value="ofinanciera">Obs. Financiera</option>
			  			<option value="mrechazo">Mot. Rechazo</option>
			  		</select>
			  	</div>
			  	<div class="form-group">
			  		<select id="forma" name="forma" class="form-control">
			  			<option value="">[FORMA...]</option>
			  			<option value="SORT_ASC">Ascendente</option>
			  			<option value="SORT_DESC">Descendente</option>
			  		</select>
			  	</div>
			</div>
	   	</div>
	   	<div class="row">
	   		<div class="navbar-form navbar-right" role="search">
			  	<div class="form-group">
			    	<?= 
			    		DatePicker::widget([
			    			'id' => 'desde',
						    'name' => 'desde',
						    'options' => ['placeholder' => 'Fecha Desde'],
						    'pluginOptions' => [
						        'format' => 'yyyy-mm-dd',
						        'todayHighlight' => true
						    ]
						]);
			    	?>
			  	</div>
			  	<div class="form-group">
			  		<?= 
			    		DatePicker::widget([
			    			'id' => 'hasta',
						    'name' => 'hasta',
						    'options' => ['placeholder' => 'Fecha Hasta'],
						    'pluginOptions' => [
						        'format' => 'yyyy-mm-dd',
						        'todayHighlight' => true
						    ]
						]);
			    	?>
			  	</div>
			</div>
	   	</div>
   	</form>
   	<div class="row">
   		<div class="navbar-form navbar-right" role="search">
   			<button type="submit" class="btn btn-primary" onclick="excel()">
   				<i class="fa fa-file-excel-o fa-fw"></i> Descargar Busqueda en Excel
   			</button>
   			<button type="submit" class="btn btn-primary" onclick="consultar(0)">
   				<i class="fa fa-search fa-fw"></i> Buscar
   			</button>
   		</div>
   	</div>
   	<div class="row">
   		<?php $form2 = ActiveForm::begin(); ?>
	    <hr>
	    <div id="info"></div>
	    <div id="partial"><?=$partial?></div>
		<?php ActiveForm::end(); ?>
   	</div>
	 
<script>
 	function eliminarPedido(id){
 		var url="<?php echo Url::toRoute('pedido/eliminar-pedido-especial')?>";
 		var r = confirm('¿Desea eliminar el Pedido?');
		if (r == true) {
		    txt = "You pressed OK!";
		    location.href=url+"?id="+id;
		} else {
		    txt = "You pressed Cancel!";
		}
 	}
 	$(document).on( "click", "#partial .pagination li", function() {
	    var page = $(this).attr('p');
	    consultar(page);
	});
	function consultar(page){
		var form=document.getElementById("form_excel");
		var input=document.getElementById("excel");
		if(input!=null){
			form.removeChild(input);
		}
		var desde=$('#desde').val();
		var hasta=$('#hasta').val();
	    var buscar=$("#buscar").val();
	    var ordenado=$("#ordenado").val();
	    var forma=$("#forma").val();
	    var dependecia=$("#dependencias2").val();
	    var regional=$("#regional").val();
	    var marca=$("#marca").val();
		$.ajax({
            url:"<?php echo Url::toRoute('pedido/historico-especial')?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                desde: desde,
                hasta: hasta,
                buscar: buscar,
                ordenado: ordenado,
                forma: forma,
                dependencias2: dependecia,
                regional: regional,
                marca: marca,
                page: page
            },
            beforeSend:  function() {
                $('#info').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                $("#partial").html(data.respuesta);
                $("#info").html('');
            }
	    });
	}
	function excel(){
		var form=document.getElementById("form_excel");
		var input = document.createElement('input');
	    input.type = 'hidden';
	    input.id = 'excel';
	    input.name = 'excel';
	    input.value = '';
	    form.appendChild(input);
		form.submit();
	}
	/*var ciudad_zona = JSON.parse('<?php //echo json_encode($ciudades_zonas_permitidas);?>');
	var dependencias = JSON.parse('<?php //echo json_encode($data_dependencias);?>');
	$("#regional").on('change',function(){
		var region= $(this).val();
		var ciudades = [];
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < ciudad_zona.length; index++ ) {
        	
            if(ciudad_zona[index]['zona_nombre']==region){//console.log("region id= "+region)
            	ciudades.push( ciudad_zona[index] );
            }
        }
        $('#ciudad').empty();
        for ( var i=0; i < ciudades.length; i++ ) {
            $('#ciudad').append($('<option>', {
			    value: ciudades[i]['nombre'],
			    text: ciudades[i]['nombre']
			}));
        }
        $('#ciudad').change();
        $('#marca').change();
   	});
   	$("#ciudad").on('change',function(){
   		$('#marca').change();
   	});
   	$("#marca").on('change',function(){
		var marca= $(this).val();
		var ciudad= $('#ciudad').val();
		var depencias = [];
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < dependencias.length; index++ ) {
        	//console.log("marca id= "+marca)
        	
        	if(dependencias[index]['nombre_ciudad']==ciudad){
        		//console.log("depen= "+dependencias[index]['nombre']+", ciudad= "+dependencias[index]['nombre_ciudad']+", marca= "+dependencias[index]['nombre_marca'])
        	}
            if(dependencias[index]['nombre_marca']==marca && dependencias[index]['nombre_ciudad']==ciudad){
            	depencias.push( dependencias[index] );
            }
        }
        $('#dependencias2').empty();
        for ( var i=0; i < depencias.length; i++ ) {
            $('#dependencias2').append($('<option>', {
			    value: depencias[i]['nombre'],
			    text: depencias[i]['nombre']
			}));
        }
        $('#dependencias2').change();
   	});*/
</script>
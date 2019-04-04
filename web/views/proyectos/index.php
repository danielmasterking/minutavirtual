<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\widgets\Select2;

$ciudades_zonas = array();
$zonas_ids = array();
foreach($zonasUsuario as $zonaO){
    $ciudades_zonas [] = $zonaO->zona->ciudades;	
	$zonas_ids [] = $zonaO->zona->id;
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
$data_dependencias[0] =  'POR DEPENDENCIA...';
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

$this->title = 'Presupuestacion de Proyectos';
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li>Presupuestacion Proyectos</li>
</ol>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('Crear Proyecto', ['create'], ['class' => 'btn btn-primary']) ?>
</p>
<form id="form_excel" method="post" action="<?php echo Url::toRoute('proyectos/index')?>">
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
		  			<option value="nombre">Nombre</option>
		  			<option value="dependencia">Dependencia</option>
		  			<option value="fecha_finalizacion">Fecha Finalizacion</option>
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
	<div id="info"></div>
	<div id="partial"><?= $respuesta?></div>
</div>
<script>
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
		$.ajax({
            url:"<?php echo Url::toRoute('proyectos/index')?>",
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
 </script>
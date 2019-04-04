<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
$this->title = 'Historico Revisión Financiera';
$data_dependencias = array();
$data_dependencias[0] =  'POR DEPENDENCIA...';
foreach($dependencias as $value){
	$data_dependencias[$value->nombre] =  $value->nombre;
}
?>
<?= $this->render('_tabsFinanciera',['historico' => $historico]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?= Html::a('Normales',Yii::$app->request->baseUrl.'/pedido/historico-financiera',['class'=>'btn btn-primary']) ?>		
<form id="form_excel" method="post" action="<?php echo Url::toRoute('pedido/historico-financiera-especial')?>">
   <div class="row">
   		<div class="navbar-form navbar-right" role="search">
		  	<div class="form-group">
		    	<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar Historial">
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
		  			<option value="cebe">CeBe</option>
		  			<option value="producto">Producto</option>
		  			<option value="cantidad">Cantidad</option>
		  			<option value="proveedor">Proveedor</option>
		  			<option value="orden">Orden Compra</option>
		  			<option value="codigo">Codigo Activo</option>
		  			<option value="ffinanciera">Fecha Financiera</option>
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
            url:"<?php echo Url::toRoute('pedido/historico-financiera-especial')?>",
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
<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use  yii\helpers\Url;

$this->title = 'Nuevo Monitoreo De Alarma';

if (isset($model->fecha_inicio)) {
	$fecha_inicio=$model->fecha_inicio;
}else{
	$fecha_inicio='';
}

if (isset($model->fecha_fin)) {
	$fecha_final=$model->fecha_fin;
}else{
	$fecha_final='';
}

?>

<div class="row">
	<div class="col-md-12">
		<?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
<?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Configuracion de Dispositivo Fijo',Yii::$app->request->baseUrl.'/centro-costo/modeloelectronico?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>
</div>
<br>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['id'=>'form_create']); ?>
<div class="row">

    <?php if(isset($actualizar)){ ?>

	<div class="col-md-1 col-md-offset-11">
		<button class="btn btn-primary btn-lg" >Actualizar</button>
	</div>

	<?php }else{ ?>

	<div class="col-md-1 col-md-offset-11">
		<button class="btn btn-primary btn-lg" >Guardar</button>
	</div>

	<?php }?>


</div>
<br>

<div class="row">
	<div class="col-md-4">
		<?= $form->field($model, 'monitoreo')->dropDownList([
			''=>'Selecciona una opcion',
			'GPRS' => 'GPRS', 
			'Línea Telefónica' => 'Línea Telefónica'
		]) ?>
	</div>

	<div class="col-md-4">
		
		<?php 
			echo $form->field($model, 'id_sistema_monitoreo')->widget(Select2::classname(), [
			    'data' =>$sistema_monitoreado,
			    'options' => ['placeholder' => 'Selecciona una opcion ','id'=>'sistema_monitoreo']
			]);

		?>
	</div>

	<div class="col-md-4">
		<?= $form->field($model, 'cantidad_servicios')->textInput(['type'=>'number','value'=>1,'id'=>'cantidad_serv']) ?>
	</div>

</div>

<div class="row">
	<div class="col-md-4">
		<?= $form->field($model, 'valor_unitario')->textInput(['id'=>'valor_unitario','readonly'=>true]) ?>
		<div id="loading"></div>
	</div>	

	<div class="col-md-4">
		<label>Fecha Inicio</label>
		<?= 
            DatePicker::widget([
                'id' => 'fecha_inicio',
                'name' => 'fecha_inicio',
                'value' => $fecha_inicio,
                'options' => ['placeholder' => 'Fecha Inicio'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
         ?>
	</div>

	<div class="col-md-4 ">
		<label>Fecha ultima reposicion</label>

		<input type="hidden" name="centro_costo" id='centro_costo' value="<?= $codigo_dependencia ?>">
		

		<?= 
            DatePicker::widget([
                'id' => 'fecha_fin',
                'name' => 'fecha_fin',
                'value' => $fecha_final,
                'options' => ['placeholder' => 'Fecha Fin'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
         ?>
	</div>

</div>

<div class="row">
	<div class="col-md-4">
		<b>TOTAL:</b><div id="total">$ 0 COP</div>
		<?= $form->field($model, 'valor_total')->textInput(['type'=>'hidden','id'=>'valor_total','readonly'=>true])->label(false) ?>
	</div>	
</div>
<script type="text/javascript">
	$(function(){
		$('#sistema_monitoreo').change(function(event) {
		 	$.ajax({
	            url:"<?php echo Yii::$app->request->baseUrl . '/centro-costo/preciomonitoreo'; ?>",
	            type:'POST',
	            dataType:"json",
	            cache:false,
	            data: {
	                sistema:$(this).val(),
	                centro_costo:$('#centro_costo').val()
	            },
	            beforeSend:  function() {
	                $('#loading').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
	            },
	            success: function(data){
	               $('#valor_unitario').val(data.precio);
	               $('#loading').html('');

	               if ($('#fecha_inicio').val()!='' && $('#fecha_fin').val()!='' ) {
	               	 calculo_total();	
	               }
	               
	              // document.write(data);
	            }
        	});
		});

		$('#cantidad_serv').keyup(function(event) {
			if ($(this).val()!='' && $('#valor_unitario').val()!='' && $('#fecha_inicio').val()!='' && $('#fecha_fin').val()!='') {
				calculo_total();
			}else if($(this).val()==''){
				$('#total').html('$ 0 COP');
			}
		});

		$('#fecha_inicio,#fecha_fin').change(function(event) {

			if($('#valor_unitario').val()!='' && $('#fecha_inicio').val()!='' && $('#fecha_fin').val()!='' && $('#cantidad_serv').val()!='' ){

				if ($('#fecha_inicio').val()>$('#fecha_fin').val()) {

					alert('La fecha de inicio no puede ser mayor a la fecha final');
					$('#fecha_fin').val('');
				}else{
					calculo_total();
				}
			}else if($('#fecha_inicio').val()=='' || $('#fecha_fin').val()==''){
				$('#total').html('$ 0 COP');
			}
		});


	});



	function calculo_total(){
		var fecha_inicio=moment($('#fecha_inicio').val());
		var fecha_final=moment($('#fecha_fin').val());
		var dias=fecha_final.diff(fecha_inicio, 'days'); 
		var cantidad_servicios=$('#cantidad_serv').val();
		var valor_unitario=$('#valor_unitario').val();

		var total=(dias)*(cantidad_servicios*valor_unitario)/(30);

		$('#total').html('$ '+total.formatPrice()+' COP');
		$('#valor_total').val(total);
	}


	Number.prototype.formatPrice = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };

</script>
<?php ActiveForm::end(); ?>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;

$this->title = 'Nuevo Dispositivo Variable';
$hora_inicio_nocturna='00:00';
$hora_fin_nocturna='00:00';
$hora_inicio_diurna='00:00';
$hora_fin_diurna='00:00';
foreach ($jornada as $key) {
	if ($key->nocturna=='S') {
		$hora_inicio_nocturna=$key->hora_inicio;
		$hora_fin_nocturna=$key->hora_fin;
	}else if ($key->nocturna=='N') {
		$hora_inicio_diurna=$key->hora_inicio;
		$hora_fin_diurna=$key->hora_fin;
	}
}
?>
<div class="row">
	<div class="col-md-12">
<?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Pre-factura',Yii::$app->request->baseUrl.'/prefactura-fija/view?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>
</div>
<br>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?php 
$puestos = array();
$data_servicios = array();
$servicios2 = array();
foreach($servicios as $value){
	$label = $value->servicio->nombre.'-'.$value->descripcion;
	$data_servicios [] = array('id' => $value->id,'ano' => $value->ano,'precio' => $value->precio,'precio_nocturno' => $value->precio_nocturno,'codigo' => $value->servicio->id, 'nombre' => $label, 'servicio_id' => $value->servicio_id);
	$servicios2 [$value->id] = $label;
}
foreach($puesto as $pt){
	$puestos [] = array('id' => $pt->id, 'nombre' => $pt->nombre, 'servicio_id' => $pt->servicio_id);
}
$tipo_servicio = array();
$tipo_servicio ['Fijo Proporcional'] = 'Fijo Proporcional';
$tipo_servicio ['Adicional'] = 'Adicional';
$tipo_servicio ['Judicializacion'] = 'Judicializacion';
$tipo_servicio ['Recargo Nocturno'] = 'Recargo Nocturno';
$tipo_servicio ['No Prestado'] = 'No Prestado';
?>
<div class="row">
	<div class="col-md-1 col-md-offset-11">
		<button class="btn btn-primary btn-lg" onclick="validar();">Guardar</button>
	</div>
</div>
<br>
<?php $form = ActiveForm::begin(['id'=>'form_create']); ?>
<div class="row">
	<div class="col-md-3">
		<?=
	       	$form->field($model, 'detalle_servicio_id')->widget(Select2::classname(), [
		   	'data' => $servicios2,
		   	'options' => ['placeholder' => 'Seleccionar Servicio', ],
	      	])
     	?>
	</div>
	<div class="col-md-3">
		<?=
	       	$form->field($model, 'puesto_id')->widget(Select2::classname(), [
		   	'data' => null,
		   	'options' => ['placeholder' => 'Seleccionar Servicio', ],
	      	])
     	?>
	</div>
	<div class="col-md-3">
		<?= $form->field($model, 'cantidad_servicios')->textInput(['value' => '1',]) ?>
	</div>
	<div class="col-md-3">
		<?=$form->field($model, 'horas')->widget(TimePicker::classname(), [
		'readonly'=>true,
		'pluginOptions' => [
	        //'showSeconds' => true,
	        'showMeridian' => false,
	        'minuteStep' => 1,
	        'secondStep' => 5,
	        'defaultTime' => '00:00:00',
	    ]])?>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<?php 
		$range = range(30, 1);
		$a = array_combine($range, $range); 
		echo $form->field($model, 'total_dias')->dropDownList($a);?>
	</div>
	<div class="col-md-4">
		<?=
	       	$form->field($model, 'tipo_servicio')->widget(Select2::classname(), [
		   	'data' => $tipo_servicio,
		   	'options' => ['placeholder' => 'Seleccionar Tipo Servicio', ],
	      	])
     	?>
	</div>
	<div class="col-md-2" align="center">
		<?=$form->field($model, 'hora_inicio')->widget(TimePicker::classname(), [
		'readonly'=>true,
		'pluginOptions' => [
	        //'showSeconds' => true,
	        'showMeridian' => false,
	        'minuteStep' => 1,
	        'secondStep' => 5,
	        'defaultTime' => '00:00:00',
	    ]])?>
	</div>
	<div class="col-md-2" align="center">
		<label>Hasta</label>
		<div id="hora_fin">00:00</div>
	</div>
	
</div>
<div class="row">
	<div class="col-md-2">
		<?php 
		$range = range(100, 0);
		$a = array_combine($range, $range); 
		echo $form->field($model, 'porcentaje')->dropDownList($a);?>
	</div>
	<div class="col-md-2">
		<label>Total FTES</label>
		<div id="ftes">0</div>
	</div>
	
	<div class="col-md-3">
		<label>Valor Servicio Col/$Mes</label>
		<div id="valor_servicio">0</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
<script>
	var servicios = JSON.parse('<?php echo json_encode($data_servicios);?>');
	var obj = JSON.parse('<?=json_encode($puestos)?>');
	var precio_servicio=0;
	var precio_servicio_nocturno=0;
	var precio_servicio_minuto=0;
	var precio_servicio_nocturno_minuto=0;
	$("#prefacturadispositivo-tipo_servicio").val('Adicional')
	//$('#prefacturadispositivo-tipo_servicio').change();
	$("#prefacturadispositivo-cantidad_servicios").on('change paste keyup',function(){
		$('#prefacturadispositivo-detalle_servicio_id').change();
	});
	$("#prefacturadispositivo-detalle_servicio_id").on('change',function(){
		var value= $(this).val();
		var puestos = [];
		var servicio_id='';
		//primero buscar en servicios el id del seleccionado para saber el servicio_id
        for ( var index=0; index < servicios.length; index++ ) {
        	console.log("servicio id= "+value)
            if(servicios[index]['id']==value){
            	servicio_id=servicios[index]['servicio_id'];
            	precio_servicio=servicios[index]['precio'];
            	precio_servicio_minuto=(((precio_servicio/30))/8)/60;
            	precio_servicio_nocturno=servicios[index]['precio_nocturno'];
            	precio_servicio_nocturno_minuto=(((precio_servicio_nocturno/30))/8)/60;
            	console.log("precio_servicio= "+precio_servicio)
            	console.log("precio_servicio_nocturno= "+precio_servicio_nocturno)
            	break;
            }
        }
        //busco en puestos el servicio_id que coincide
        for ( index=0; index < obj.length; index++ ) {
            if(obj[index]['servicio_id']==servicio_id){
            	puestos.push( obj[index] );
            }
        }
        $('#prefacturadispositivo-puesto_id').empty();
        for ( var i=0; i < puestos.length; i++ ) {
            $('#prefacturadispositivo-puesto_id').append($('<option>', {
			    value: puestos[i]['id'],
			    text: puestos[i]['nombre']
			}));
        }
        $('#prefacturadispositivo-puesto_id').change();
        calcularHoraFin()
   	});
	
	$("#prefacturadispositivo-total_dias").on('change',function(){
		calcularHoraFin()
   	});
	$("#prefacturadispositivo-horas").on('change',function(){
   		calcularHoraFin()
   	});
   	$("#prefacturadispositivo-hora_inicio").on('change',function(){
   		calcularHoraFin()
   	});
   	$("#prefacturadispositivo-porcentaje").on('change',function(){
   		calcularHoraFin()
   	});
   	function calcularHoraFin(){
   		var hora_sumar = moment($("#prefacturadispositivo-horas").val(), "hh-mm").hour();
   		var minuto_sumar = moment($("#prefacturadispositivo-horas").val(), "hh-mm").minute();
   		var hora_final = moment($("#prefacturadispositivo-hora_inicio").val(), "hh-mm");
   		hora_final.add(hora_sumar, 'hours').add(minuto_sumar, 'minutes');
   		$("#hora_fin").html(hora_final.format("HH:mm"))
   		calcularHorasDiurnasNocturnas()
   	}
   	var inicio_nocturno='<?=$hora_inicio_nocturna?>'//'22:00';
   	var fin_nocturno='<?=$hora_fin_nocturna?>'//'05:59';
   	var inicio_diurno='<?=$hora_inicio_diurna?>'//'06:00';
   	var fin_diurno='<?=$hora_fin_diurna?>'//'21:59';
   	var hora_inicio='';
   	var hora_fin='';
   	var tiempo_diurna='';
   	var tiempo_nocturno='';
   	var tiempo_diurna2=0;
   	var tiempo_nocturno2=0;
   	var hora24='24:00';
   	var hora00='00:00';
   	function calcularHorasDiurnasNocturnas(){
   		var jornada=moment.utc($("#prefacturadispositivo-hora_inicio").val(), "hh:mm");
   		hora_inicio=moment.utc($("#prefacturadispositivo-hora_inicio").val(), "hh:mm");
   		hora_fin=moment.utc($("#hora_fin").html(), "hh:mm");
   		inicio_nocturno=moment.utc(inicio_nocturno, "hh:mm");
   		fin_nocturno=moment.utc(fin_nocturno, "hh:mm");
   		inicio_diurno=moment.utc(inicio_diurno, "hh:mm");
   		fin_diurno=moment.utc(fin_diurno, "hh:mm");
   		tiempo_nocturno=moment.utc('00:00', "hh-mm")
   		tiempo_diurna=moment.utc('00:00', "hh-mm")
   		hora00=moment.utc(hora00, "hh:mm");
   		hora24=moment.utc(hora24, "hh:mm");
   		var hi=hora_inicio;//.hour();
   		//console.log(hi)
   		var hf=hora_fin;//.hour();
   		//console.log(hf)
   		var muere=false;
   		if (hi.isSameOrAfter(hora00) && hi.isBefore(inicio_diurno)) {// desde las 00 a las 06
   			if (hf.isSameOrAfter(hora00) && hf.isBefore(inicio_diurno) && hi.isBefore(hf)) {
	   			tiempo_nocturno2=hora_inicio.diff(hora_fin);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
		   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
		   		//console.log("+N 0-6= "+tiempo_nocturno.format("HH:mm"))
			   	muere=true;
	   		}else{
	   			tiempo_nocturno2=hora_inicio.diff(inicio_diurno);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
		   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
			   	//console.log("+N 0-6= "+tiempo_nocturno.format("HH:mm"))
	   		}
   		}else if (hi.isSameOrAfter(inicio_diurno) && hi.isBefore(inicio_nocturno)) {// desde las 06 hasta las 21
   			if (hf.isSameOrAfter(inicio_diurno) && hf.isBefore(inicio_nocturno) && hi.isBefore(hf)) {
	   			tiempo_diurna2=hora_inicio.diff(hora_fin);
	   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
			   	//console.log("+D 6= "+tiempo_diurna.format("HH:mm"))
			   	muere=true;
	   		}else{
	   			tiempo_diurna2=hora_inicio.diff(inicio_nocturno);
	   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
			   	//console.log("+D 6= "+tiempo_diurna.format("HH:mm"))
	   		}
   		}else if (hi.isSameOrAfter(inicio_nocturno) && hi.isBefore(hora24)) {// desde las 21 a las 00
   			if(hf.isSameOrAfter(inicio_nocturno) && hf.isBefore(hora24) && hi.isBefore(hf)){
   				tiempo_nocturno2=hora_inicio.diff(hora_fin);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
			   	muere=true;
			   	//console.log("+N 22= "+tiempo_nocturno.format("HH:mm"))
   			}else{
   				tiempo_nocturno2=hora_inicio.diff(hora24);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
			   	//console.log("+N 22= "+tiempo_nocturno.format("HH:mm"))
   			}
   		}
   		//buscando la hora final
   		if (!muere) {
   			if (hf.isSameOrAfter(hora00) && hf.isBefore(inicio_diurno)) {// desde las 00 a las 06
   				if(hi.isSameOrAfter(hora00) && hi.isBefore(inicio_diurno)){
   					//sumar diurno y de 21 a 24
   					tiempo_diurna2=inicio_diurno.diff(inicio_nocturno);
		   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
				   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
				   	//console.log("+D muere 0-6= "+tiempo_diurna.format("HH:mm"))
				   	tiempo_nocturno2=inicio_nocturno.diff(hora24);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 0-6= "+tiempo_nocturno.format("HH:mm"))
   				}else if(hi.isSameOrAfter(inicio_diurno) && hi.isBefore(inicio_nocturno)){
   					//sumar de 22 a 24
   					tiempo_nocturno2=inicio_nocturno.diff(hora24);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 0-6= "+tiempo_nocturno.format("HH:mm"))
   				}
	   			tiempo_nocturno2=hora00.diff(hora_fin);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
		   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
			   	//console.log("+N muere 0-6= "+tiempo_nocturno.format("HH:mm"))
	   		}else if (hf.isSameOrAfter(inicio_diurno) && hf.isBefore(inicio_nocturno)) {//desde las 06 a las 21
	   			if(hi.isSameOrAfter(inicio_diurno) && hi.isBefore(inicio_nocturno)){
   					//sumar de 22 a 24 y de 0 a 6
   					tiempo_nocturno2=inicio_nocturno.diff(hora24);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 6-22= "+tiempo_nocturno.format("HH:mm"))
				   	tiempo_nocturno2=hora00.diff(inicio_diurno);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 6-22= "+tiempo_nocturno.format("HH:mm"))
   				}else if(hi.isSameOrAfter(inicio_nocturno) && hi.isBefore(hora24)){
   					//sumar de 0 a 6
				   	tiempo_nocturno2=hora00.diff(inicio_diurno);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 6-22= "+tiempo_nocturno.format("HH:mm"))
   				}
	   			tiempo_diurna2=inicio_diurno.diff(hora_fin);
	   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
			   	//console.log("+D muere 6-22= "+tiempo_diurna.format("HH:mm"))
	   		}else if (hf.isSameOrAfter(inicio_nocturno) && hf.isBefore(hora24)) {//desde las 21 a las 00
   				if(hi.isSameOrAfter(inicio_nocturno) && hi.isBefore(hora24)){
   					//sumar de 0 a 6 y sumar diurno
				   	tiempo_nocturno2=hora00.diff(inicio_diurno);
		   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
			   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
				   	//console.log("+N muere 22-24= "+tiempo_nocturno.format("HH:mm"))
				   	tiempo_diurna2=inicio_diurno.diff(inicio_nocturno);
		   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
				   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
				   	//console.log("+D muere 22-24= "+tiempo_diurna.format("HH:mm"))
   				}else if(hi.isSameOrAfter(hora00) && hi.isBefore(inicio_diurno)){
   					// sumar diurno
   					tiempo_diurna2=inicio_diurno.diff(inicio_nocturno);
		   			tiempo_diurna.add(0+Math.abs(moment.duration(tiempo_diurna2).hours()), 'hours')
				   			.add(0+Math.abs(moment.duration(tiempo_diurna2).minutes()), 'minutes');
				   	//console.log("+D muere 22-24= "+tiempo_diurna.format("HH:mm"))
   				}
	   			tiempo_nocturno2=inicio_nocturno.diff(hora_fin);
	   			tiempo_nocturno.add(0+Math.abs(moment.duration(tiempo_nocturno2).hours()), 'hours')
		   			.add(0+Math.abs(moment.duration(tiempo_nocturno2).minutes()), 'minutes');
			   	//console.log("+N muere 22= "+tiempo_nocturno.format("HH:mm"))
	   		}
   		}
   		//rectificacion por reseteo de calculos hasta 24 horas
   		if (jornada.isSame(hora00) && (hi.duration().asMinutes()-hf.duration().asMinutes())==0) {
   			tiempo_nocturno=moment.utc('00:00', "hh-mm")
   			tiempo_diurna=moment.utc('00:00', "hh-mm")
   			tiempo_nocturno.add(8, 'hours')
		   			.add(0, 'minutes');
		   	tiempo_diurna.add(16, 'hours')
		   			.add(0, 'minutes');
   		}
   		calcularFtes()
   		console.log("D= "+tiempo_diurna.format("HH:mm"))
	   	console.log("N= "+tiempo_nocturno.format("HH:mm"))
   	}
   	var ftes_diurno=0;var ftes_nocturno=0;
   	function calcularFtes(){
   		var dias_prestados=parseInt($('#prefacturadispositivo-total_dias').val())
	   	var cantidad=parseInt($('#prefacturadispositivo-cantidad_servicios').val())
	   	ftes_diurno=(((tiempo_diurna.hours()+(tiempo_diurna.minutes()/60))*dias_prestados*cantidad)/240);
	   	ftes_nocturno=(((tiempo_nocturno.hours()+(tiempo_nocturno.minutes()/60))*dias_prestados*cantidad)/240);
	   	var total_ftes=((ftes_diurno + ftes_nocturno)*parseInt($('#prefacturadispositivo-porcentaje').val()))/100;
	   	ftes_diurno=Number(Math.round(ftes_diurno+'e2')+'e-2')
	   	ftes_nocturno=Number(Math.round(ftes_nocturno+'e2')+'e-2')
	   	total_ftes=Number(Math.round(total_ftes+'e2')+'e-2')
	   	$('#ftes').html(total_ftes)
	   	//console.log("ftes_diurno= "+ftes_diurno)
	   	//console.log("ftes_nocturno= "+ftes_nocturno)
	   	//console.log("total_ftes= "+total_ftes)
	   	calcularPrecio();
   	}
   	var col_mes_diurno=0;
   	var col_mes_nocturno=0;
   	var suma_valor_servicio=0;
   	function calcularPrecio(){
   		//console.log("precio_servicio_minuto= "+precio_servicio_minuto)
   		var cantidad=parseInt($('#prefacturadispositivo-cantidad_servicios').val())
   		var dias_prestados=parseInt($('#prefacturadispositivo-total_dias').val())
   		var dia1diurno=(moment.duration(tiempo_diurna.format("HH:mm")).asMinutes())*precio_servicio_minuto
   		var total_diurno=((dia1diurno*dias_prestados)*parseInt($('#prefacturadispositivo-porcentaje').val()))/100;
   		col_mes_diurno=Number(Math.round((total_diurno*cantidad)+'e2')+'e-2');
   		//console.log("Precio diurno= "+col_mes_diurno)
		
   		var dia1nocturno=(moment.duration(tiempo_nocturno.format("HH:mm")).asMinutes())*precio_servicio_nocturno_minuto
   		
   		var total_nocturno=((dia1nocturno*dias_prestados)*parseInt($('#prefacturadispositivo-porcentaje').val()))/100;
   		col_mes_nocturno=Number(Math.round((total_nocturno*cantidad)+'e2')+'e-2');
   		//console.log("Precio nocturno= "+col_mes_nocturno)
   		//suma_valor_servicio=col_mes_diurno+col_mes_nocturno;
   		////////////////////////////////////////////////////
   		var tipo_serv=$('#prefacturadispositivo-tipo_servicio option:selected').val();

   		
   		if(tipo_serv=='Recargo Nocturno'){
   			//alert('entro');
   			var resta=precio_servicio_nocturno_minuto-precio_servicio_minuto;   			
   			var tiempo=(moment.duration(tiempo_nocturno.format("HH:mm")).asMinutes())*resta;
   			var total_recargo=((tiempo*dias_prestados)*parseInt($('#prefacturadispositivo-porcentaje').val()))/100;
   		    suma_valor_servicio=Number(Math.round((total_recargo*cantidad)+'e2')+'e-2');
   			 $('#valor_servicio').html('$ '+suma_valor_servicio.formatPrice()+' COP');

   			console.log("precio_nocturno="+precio_servicio_nocturno_minuto);
   			console.log("precio_diurno="+precio_servicio_minuto);
   			console.log("resta="+resta);
   			console.log("tiempo="+(moment.duration(tiempo_nocturno.format("HH:mm")).asMinutes()));


   		}else{
   			suma_valor_servicio=col_mes_diurno+col_mes_nocturno;
   			$('#valor_servicio').html('$ '+suma_valor_servicio.formatPrice()+' COP');
   		}




   	}

  

   	Number.prototype.formatPrice = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
   	$("#prefacturadispositivo-horas").val('08:00')
   	$("#prefacturadispositivo-hora_inicio").val('06:00')

   	function validar(){
   		$('<input>').attr({
		    type: 'hidden',
		    id: 'hora_fin2',
		    name: 'hora_fin2',
		    value: $('#hora_fin').html()
		}).appendTo('#form_create');
		$('<input>').attr({
		    type: 'hidden',
		    id: 'ftes2',
		    name: 'ftes2',
		    value: $('#ftes').html()
		}).appendTo('#form_create');
		$('<input>').attr({
		    type: 'hidden',
		    id: 'valor_servicio2 ',
		    name: 'valor_servicio2',
		    value: suma_valor_servicio
		}).appendTo('#form_create');
		$('<input>').attr({
		    type: 'hidden',
		    id: 'ftes_diurno ',
		    name: 'ftes_diurno',
		    value: ftes_diurno
		}).appendTo('#form_create');
		$('<input>').attr({
		    type: 'hidden',
		    id: 'ftes_nocturno ',
		    name: 'ftes_nocturno',
		    value: ftes_nocturno
		}).appendTo('#form_create');
        $('#form_create').yiiActiveForm('submitForm');
    }
</script>
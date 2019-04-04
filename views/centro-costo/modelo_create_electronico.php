<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use  yii\helpers\Url;

$this->title = 'Nuevo Dispositivo Fijo de Seguridad Electronica';


if (isset($list_descripcion)) {
	$descripcion_alarma=$list_descripcion;
}else{
	$descripcion_alarma=[];
}


if (isset($model->fecha_inicio)) {
	$fecha_inicio=$model->fecha_inicio;
}else{
	$fecha_inicio='';
}

if (isset($model->fecha_ultima_reposicion)) {
	$fecha_final=$model->fecha_ultima_reposicion;
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
		<?php 
			echo $form->field($model, 'id_tipo_alarma')->widget(Select2::classname(), [
			    'data' =>$alarmas,
			    'options' => ['placeholder' => 'Selecciona un tipo de alarma','id'=>'tipo_alarma']
			]);

		?>
	</div>

	<div class="col-md-4">
		
		<?php 
			echo $form->field($model, 'id_desc')->widget(DepDrop::classname(), [
				    'data'=> $descripcion_alarma,
				    'options' => ['placeholder' => 'Selecciona un tipo de alarma  ...'],
				    'type' => DepDrop::TYPE_SELECT2,
				    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
				    'pluginOptions'=>[
				        'depends'=>['tipo_alarma'],
				        'url' => Url::to(['/centro-costo/descripcion_alarma']),
				        'loadingText' => 'cargando ...',
				    ]
				]);
		?>
	</div>

	<div class="col-md-4">
		<?php 
			echo $form->field($model, 'id_marca')->widget(Select2::classname(), [
			    'data' =>$marcas_alarma,
			    'options' => ['placeholder' => 'Selecciona una marca de alarma']
			]);

		?>
	</div>

</div>


<div class="row">
	<div class="col-md-4">
		<?= $form->field($model, 'estado')->dropDownList([
			'Conectado' => 'Conectado', 
			'Anulado' => 'Anulado'
		]) ?>
	</div>

	<div class="col-md-4">
		<?= $form->field($model, 'sistema')->dropDownList([
			'Inalámbrico' => 'Inalámbrico', 
			'Alambrado' => 'Alambrado'
		]) ?>
	</div>


	<div class="col-md-4">
		<?= $form->field($model, 'referencia')->textInput() ?>
	</div>

</div>



<div class="row">
	
	<div class="col-md-4">
		<?php 
			echo $form->field($model, 'ubicacion')->widget(Select2::classname(), [
			    'data' =>$areas,
			    'options' => ['placeholder' => 'Selecciona un area']
			]);

		?>
	</div>

	<div class="col-md-4">
		<?= $form->field($model, 'zona_panel')->textInput() ?>
	</div>

	<div class="col-md-4">
		<?php 
			echo $form->field($model, 'meses_pactados')->widget(Select2::classname(), [
			    'data' =>$meses,
			    'options' => ['placeholder' => 'Selecciona cantidad de meses']
			]);

		?>
	</div>

</div>




<div class="row">
	
	<div class="col-md-6">
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

	<div class="col-md-6">
		<label>Fecha ultima reposicion</label>

		<input type="hidden" name="centro_costo" value="<?= $codigo_dependencia ?>">
		

		<?= 
            DatePicker::widget([
                'id' => 'fecha_ultima_reposicion',
                'name' => 'fecha_ultima_reposicion',
                'value' => $fecha_final,
                'options' => ['placeholder' => 'Fecha ultima reposicion'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
         ?>
	</div>

</div>

<br>
<div class="row">
	
	<div class="col-md-6">

		<?=

			$form->field($model, 'valor_arrendamiento_mensual')->widget(MaskMoney::classname(), [
			    'pluginOptions' => [
			        'thousands' => '.',
			        'decimal' => ',',
			        'precision' => 0, 
			        'allowZero' => true,
			        'allowNegative' => false,
			        'suffix' => '',
			        'prefix' => '',
			    ]
			]); 


		?>
	</div>
</div>


<?php ActiveForm::end(); ?>
<script>
	$(function(){
		//$("#valor_mensual").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
		$('#form_create').submit(function(event) {
			var fecha_inicio=$('#fecha_inicio').val();
			var fecha_final=$('#fecha_ultima_reposicion').val();


			if (fecha_final<fecha_inicio) {
				alert('La fecha de ultima reposicion no puede ser menor a la fecha de inicio');

				return false;

			}else if(fecha_final==''){
				alert('La fecha de ultima reposicion no puede estar vacia');

				return false;
			}else if(fecha_inicio==''){
				alert('La fecha de inicio  no puede estar vacia');

				return false;
			}


		});


		


	});
</script>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\money\MaskMoney;
Select2::widget([
	'id' => 'xxx',
    'name' => 'xxx',
    'value' => '',
    'options' => ['multiple' => false]
]);
MaskMoney::widget([
    'name' => 'xxxx',
    'value' => 20322.22
]);
?>
	<?php $form = ActiveForm::begin([
      	'id' => 'pedido-form',
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
	<div class="row">
		<div class="col-md-12">
			<label for="tipo_presupuesto">Elija a que presupuesto se va a descontar el pedido</label>
			<select id="tipo_presupuesto" name="tipo_presupuesto" class="form-control">
				<option value="0">[Elegir tipo del Presupuesto]</option>
				<option value="seguridad">Seguridad</option>
				<option value="riesgo">Riesgo</option>
				<option value="heas">Heas</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label for="file">Adjuntar Cotizacion</label>
			<?php
				echo FileInput::widget([
					'id' => 'file',
				    'name' => 'file',
				    'pluginOptions'=>['allowedFileExtensions'=>['xls', 'xlsx', 'pdf','jpg','png','gif','jpeg'],
								   'maxFileSize' => 5120,
				  	]
				]);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>&nbsp;</p>
			<button type="button" id="btn-add-producto-especial" class="btn btn-default btn-primary pull-right" aria-label="Left Align">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			</button>
			<p>&nbsp;</p>
			<div id="productos" class="col-md-12"></div>
		</div>
	</div>
	<p>&nbsp;</p>
	<div class="row">
		<div class="col-md-12">
			<textarea name="observaciones" id="observaciones" class="form-control" rows=6></textarea>
		</div>
	</div>
	<input type="hidden" name="cantidad-productos" id="cantidad-productos" value="0"/>
<?php ActiveForm::end(); ?>
<p>&nbsp;</p>
<button class="btn btn-primary btn-lg" onclick="validarPedido();">Crear</button>

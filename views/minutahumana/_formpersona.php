<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-form">

    <?php $form = ActiveForm::begin(['id'=>'formPersona']); ?>
    <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="alert_person">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <div id="resp_person"></div>
	</div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'cedula')->textInput() ?>    
        </div>
        
    </div>


    <div class="row">
        
        <div class="col-md-6">
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
        </div>
    
        <div class="col-md-6">
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php //echo $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <!-- <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Femenino', ], ['prompt' => '']) ?>
        </div>

        <div class="col-md-6">
           <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->

    <!-- <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->field($model, 'estado')->dropDownList([ 'A' => 'Activo', 'I' => 'Inactivo', ], ['prompt' => '']) ?>
        </div>
    </div>

    <?php //echo $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php //echo Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <button type="button" class="btn btn-primary" onclick="crearPersona();">Crear</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
	
	function crearPersona(){

		$.ajax({
            url:"<?php echo Url::toRoute('minutahumana/crear_persona')?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data:$("#formPersona").serialize(),
            beforeSend:  function() {
                //$('#info').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){

            	//if(data.respuesta==0){
                	//$("#resp_person").html(data.error);
                //}
                if(data.respuesta==0){
	                var string='';
	                for(var i in data.error) {

	                	string+=data.error[i][0]+"<br>";
	                }

	                $('#alert_person').show();
	                $("#resp_person").html(string);
	            }else{
	            	$('#alert_person').hide();
	            	sweetAlert('Listo','Persona registrada correctamente', 'success');
	            	vaciar();
	            	$('#myModal1').modal('hide');
	            }
            }
        });

	}


	function vaciar(){

		$("#formPersona input").val('');
	}

</script>

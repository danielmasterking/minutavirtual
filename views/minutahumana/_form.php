<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\MinutaHumana */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="minuta-humana-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        if (isset($actualizar)) {
    ?>
    <input type="hidden" name="id" value="<?= $model->id ?>">
    <?php }?>

    <div class="row">
        <div class="col-md-12">
            <?php

                echo Select2::widget([
                    'name' => 'personas_listado',
                    'data' => $array_personas,
                    'options' => ['placeholder' => 'Selecciona persona ...','id'=>'person_id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

            ?>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-12" >
            <?= $form->field($model, 'cedula_persona')->textInput(['id'=>'cedula','onkeypress'=>'return pulsar(event)','disabled'=>isset($actualizar)?true:false,'title'=>'Digita el numero de cedula luego presiona enter','placeholder'=>'Ingresa numero de identificacion...' ])->label(''); ?>        
        </div>

    </div> 

    <button type="button" class="btn btn-primary" id="boton-verificar" style="display: inline-block;"><i class="fa fa-check"></i> Verificar</button>
            
    <div id="load"></div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php date_default_timezone_set ( 'America/Bogota'); ?>

            <?php echo $form->field($model, 'hora_entrada')->widget(TimePicker::classname(), ['pluginOptions' => [
            //'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
            'defaultTime' => date('H:i:s'),
        ],'readonly'=>true]); ?>           
        </div>

        <!-- <div class="col-md-6">
             
            <?php //echo $form->field($model, 'hora_salida')->widget(TimePicker::classname(), ['pluginOptions' => [
        //     //'showSeconds' => true,
        //     'showMeridian' => false,
        //     'minuteStep' => 1,
        //     'secondStep' => 5,
        //     'defaultTime' =>'' /*'00:00:00',*/
        // ],'disabled'=>true]); ?>       
        </div> -->

         <div class="col-md-6">
            
            <?php 
                echo $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                    'options' => ['id' => 'fecha','name' => 'fecha','value'=>date('Y-m-d'),'readonly'=>true],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                    ]
                ]);

            ?>        
        </div>

    </div>
    

    <div class="row">
        <div class="col-md-6">
            <?php 
                if (isset($actualizar)) {
                    echo $form->field($model, 'tipo_invitado')->dropDownList($list_inv, ['prompt' => '','disabled'=>true]); 
                }else{

                    echo $form->field($model, 'tipo_invitado')->widget(Select2::classname(), [
                        'data' =>$list_inv,
                        'options' => ['placeholder' => 'Selecciona una opcion','id'=>'tipo_person']
                    ]);
                }

            ?> 
               
        </div>

        <div class="col-md-6">
            <?php 

                if (isset($actualizar)) {
                    echo $form->field($model, 'tipo_observacion')->dropDownList($list_obs, ['prompt' => '','disabled'=>true]); 
                }else{
                    echo $form->field($model, 'tipo_observacion')->widget(Select2::classname(), [
                        'data' =>$list_obs,
                        'options' => ['placeholder' => 'Selecciona una opcion']
                    ]);
                }

            ?>  
                
        </div>

    </div>

    <div class="row" id="div_invitado" style="display:none;">
           <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-arrow-right"></span>Area de ingreso? <a href="http://www.jquery2dotnet.com" target="_blank"><span
                            class="glyphicon glyphicon-new-window"></span></a>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">

                        <?php foreach($areas as $row_area):?>

                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="area_dependencia" value="<?= $row_area->id ?>">
                                    <?= $row_area->nombre ?>
                                </label>
                            </div>
                        </li>

                    <?php endforeach;?>
                        
                    </ul>
                </div>
                <!-- <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-sm">
                        Vote</button>
                    
                </div> -->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            
           <?php 

               

                echo $form->field($model, 'codigo_dependencia')->widget(Select2::classname(), [
                    'data' =>$list_dependencia,
                    'options' => ['placeholder' => 'Selecciona una dependencia']
                ]);
                

            ?>      
        </div>

         <div class="col-md-6">
            <?php echo $form->field($model, 'puesto')->dropDownList($list_puestos, ['prompt' => '']) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'observacion')->textarea(['rows'=>3]) ?>
        </div>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','disabled'=>isset($actualizar)?false:true ,'id'=>'create']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    
    $('#person_id').change(function(event) {
       let cedula=$(this).val();
       $('#cedula').val(cedula);

       if(cedula!=''){
        buscar_persona();
       }else{
            $('#create').attr({
                disabled: true
            });
       }

    });


    $('#cedula').keypress(function(event) {
        if(event.which == 13){
            buscar_persona();
        }else{

            $('#create').attr({
                disabled: true
            });
        }


    });

    $('#boton-verificar').click(function(){
        buscar_persona();
    });


    function buscar_persona(){

        var cedula=$('#cedula').val();
        if (cedula=='') {
            sweetAlert('Oops...', 'Cedula Vacia', 'warning');
        }else{
            $.ajax({
                url:"<?php echo Url::toRoute('minutahumana/persona')?>",
                type:'POST',
                dataType:"json",
                cache:false,
                data: {
                    cedula: cedula,
                    
                },
                beforeSend:  function() {
                    $('#load').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                },
                success: function(data){
                    

                    $("#load").html('');

                    if (data.respuesta==1 && data.estado=='A') {

                        sweetAlert('Ingreso Correcto...', '<b>'+data.persona+'</b>', 'success');

                        $('#create').removeAttr('disabled');

                    }else if(data.respuesta==1 && data.estado=='I'){

                        sweetAlert('Ingreso Restringido', '<b>'+data.persona+'</b> esta inactivo/a', 'warning');

                    }else{

                        sweetAlert('Oops...', 'Persona no registrada', 'warning');

                        $('#personas-cedula').val($('#cedula').val());

                        $('#myModal1').modal('show')

                    }
                }
            });
        }

    }
    // $('#w0').submit(function(event) {
    //    var hora_entrada=$('#minutahumana-hora_entrada').val();


    //    if(hora_entrada=='00:00'){

    //         sweetAlert('Oops...', 'Ingresar la hora de entrada', 'error');

    //         return false;


    //    }
    // });


    function pulsar(e) {
      tecla = (document.all) ? e.keyCode :e.which;
      return (tecla!=13);
    } 


</script>
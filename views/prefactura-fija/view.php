<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prefactura Fijas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
?>
<h3 style="text-align: center;">Prefactura <?=$model->fkDependencia->nombre?> mes de <?=strtoupper ($meses[$model->mes-1]);?> de <?=$model->ano?></h3>
<?= Html::a('<i class="fa fa-arrow-left"></i> Volver a Pre-facturas',Yii::$app->request->baseUrl.'/prefactura-fija/index', ['class'=>'btn btn-primary']) ?>
<br><br>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
            MES DE FACTURACION<br>
            <b><?=strtoupper ($meses[$model->mes-1]);?></b>
            </div>
            <div class="col-md-6">
                REGIONAL<br>
                <b><?=strtoupper ($model->regional);?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                EMPRESA DE SEGURIDAD<br>
                <b><?=$model->fkEmpresa->nombre?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                CIUDAD<br>
                <b><?=strtoupper ($model->ciudad);?></b>
            </div>
            <div class="col-md-6">
                MARCA<br>
                <b><?=strtoupper ($model->marca);?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                DEPENDENCIA<br>
                <b><?=$model->fkDependencia->nombre?></b>
            </div>
            <div class="col-md-6">
                CEBE<br>
                <b><?=$model->fkDependencia->cebe?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                CECO<br>
                <b><?=$model->fkDependencia->ceco?></b>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <img src="<?=Url::to('@web/'.$model->fkEmpresa->logo, true)?>" width="200" width="110"/>
    </div>
</div>
<div id="info"></div>
<?php if($model->estado=='abierto'){?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-danger" onclick="actualizar();"><i class="fa fa-key"></i> Finalizar Prefactura</button>
    </div>
</div>
<?php }?>
<br>
<!-- ********************************************************************* -->

<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Dispositivos fijos
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Servicio</th>
                            <th style="width: 7%;">Puesto</th>
                            <th style="width: 3%;">Cant</th>
                            <th style="width: 5%;">Jornada (Horas)</th>
                            <th style="width: 5%;">Desde</th>
                            <th style="width: 5%;">Hasta</th>
                            <th style="width: 1%;">L</th>
                            <th style="width: 1%;">M</th>
                            <th style="width: 1%;">M</th>
                            <th style="width: 1%;">J</th>
                            <th style="width: 1%;">V</th>
                            <th style="width: 1%;">S</th>
                            <th style="width: 1%;">D</th>
                            <th style="width: 1%;">F</th>      
                            <th style="width: 3%;">% de Cobro</th>
                            <th style="width: 3%;">FTES</th>
                            <th style="width: 3%;">Total Días</th>
                            <th style="width: 5%;"></th>
                            <th style="width: 15%;">$/Mes</th>
                        </tr>
                    </thead>
                    <?php 
                    $total_ftes_fijos = 0;
                    $total_ftes_fijos_diurnos = 0;
                    $total_ftes_fijos_nocturnos = 0;
                    $total_servicio_fijo = 0;
                    foreach ($dispositivos as $value) {
                        if($value->tipo=='fijo'){
                        ?>
                        <tr>
                            <td><?=$value->servicio->servicio->nombre.'-'.$value->servicio->descripcion?></td>
                            <td><?=$value->puesto->nombre?></td>
                            <td><?=$value->cantidad_servicios?></td>
                            <td>
                            <?php
                                $date = new DateTime($value->horas);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td>
                            <?php
                                $date = new DateTime($value->hora_inicio);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td>
                            <?php
                                $date = new DateTime($value->hora_fin);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td><?=$value->lunes?></td>
                            <td><?=$value->martes?></td>
                            <td><?=$value->miercoles?></td>
                            <td><?=$value->jueves?></td>
                            <td><?=$value->viernes?></td>
                            <td><?=$value->sabado?></td>
                            <td><?=$value->domingo?></td>
                            <td><?=$value->festivo?></td>
                            <td><?=$value->porcentaje?></td>
                            <td><?=$value->ftes?></td>
                            <td><?=$value->total_dias?></td>
                            <?php
                                $total_ftes_fijos = $total_ftes_fijos + $value->ftes;
                                $total_ftes_fijos_diurnos = $total_ftes_fijos_diurnos + $value->ftes_diurno;
                                $total_ftes_fijos_nocturnos = $total_ftes_fijos_nocturnos + $value->ftes_nocturno;
                                $total_servicio_fijo = $total_servicio_fijo + $value->valor_mes;
                            ?>
                            <td></td>
                            <td>
                                <?='$ '.number_format($value->valor_mes, 0, '.', '.').' COP'?>
                            </td>
                        </tr>
                    <?php } 
                    } ?>
                    <tr>           
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>   
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong><?=$total_ftes_fijos?></strong></td>
                        <td></td>
                        <td></td>         
                        <td>
                            <?='$ '.number_format($total_servicio_fijo, 0, '.', '.').' COP'?>
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                Dispositivos Variables
            </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
        <?php
        if($model->estado=='abierto'){
            echo Html::a('<i class="fa fa-plus"></i> Agregar Nuevo Variable',Yii::$app->request->baseUrl.'/prefactura-fija/create-dispositivo?id='.$model->id,['class'=>'btn btn-primary']);
        }
        ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Servicio</th>
                            <th style="width: 7%;">Puesto</th>
                            <th style="width: 3%;">Cant</th>
                            <th style="width: 5%;">Jornada (Horas)</th>
                            <th style="width: 5%;">Servicio(Tipo)</th>
                            <th style="width: 5%;">Desde</th>
                            <th style="width: 5%;">Hasta</th>
                            <th style="width: 3%;">% de Cobro</th>
                            <th style="width: 3%;">FTES</th>
                            <th style="width: 3%;">Total Días</th>
                            <th style="width: 15%;">$/Mes</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <?php 
                    $total_ftes_variable = 0;
                    $total_ftes_variable_diurno = 0;
                    $total_ftes_variable_nocturno = 0;
                    $total_servicio_variable = 0;
                    $ftes_fijo_proporcional=0;
                    $ftes_adicinonal=0;
                    $ftes_recargo_nocturno=0;
                    $ftes_judicial=0;
                    $ftes_noprestados=0;

                    $total_fijo_proporcional = 0;
                    $total_adicional = 0;
                    $total_recargo_nocturno = 0;
                    $total_judicial = 0;
                    $total_noprestado = 0;
                    foreach ($dispositivos as $value) {
                        if($value->tipo=='variable'){
                            if($value->tipo_servicio=='Fijo Proporcional'){
                                $ftes_fijo_proporcional = $ftes_fijo_proporcional + $value->ftes;
                                $total_fijo_proporcional = $total_fijo_proporcional + $value->valor_mes;
                            }else if($value->tipo_servicio=='Adicional'){
                                $ftes_adicinonal = $ftes_adicinonal + $value->ftes;
                                $total_adicional = $total_adicional + $value->valor_mes;
                            }else if($value->tipo_servicio=='Judicializacion'){
                                // $ftes_recargo_nocturno = $ftes_recargo_nocturno + $value->ftes;
                                // $total_recargo_nocturno = $total_recargo_nocturno + $value->valor_mes;

                                $ftes_judicial = $ftes_judicial + $value->ftes;
                                $total_judicial = $total_judicial + $value->valor_mes;

                            }else if($value->tipo_servicio=='Recargo Nocturno'){
                                // $ftes_judicial = $ftes_judicial + $value->ftes;
                                // $total_judicial = $total_judicial + $value->valor_mes;



                                $ftes_recargo_nocturno = $ftes_recargo_nocturno + $value->ftes;
                                $total_recargo_nocturno = $total_recargo_nocturno + $value->valor_mes;

                            }else if($value->tipo_servicio=='No Prestado'){
                                $ftes_noprestados = $ftes_noprestados + $value->ftes;
                                $total_noprestado = $total_noprestado + $value->valor_mes;

                            }
                        ?>
                        <tr>
                            <td><?=$value->servicio->servicio->nombre.'-'.$value->servicio->descripcion?></td>
                            <td><?=$value->puesto->nombre?></td>
                            <td><?=$value->cantidad_servicios?></td>
                            <td>
                            <?php
                                $date = new DateTime($value->horas);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td><?=$value->tipo_servicio?></td>
                            <td>
                            <?php
                                $date = new DateTime($value->hora_inicio);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td>
                            <?php
                                $date = new DateTime($value->hora_fin);
                                echo $date->format('H:i');
                            ?>
                            </td>
                            <td><?=$value->porcentaje?></td>
                            <td><?=$value->ftes?></td>
                            <td><?=$value->total_dias?></td>
                            <?php
                            if($value->tipo_servicio !='No Prestado'){

                                $total_ftes_variable = $total_ftes_variable + $value->ftes;
                                $total_ftes_variable_diurno = $total_ftes_variable_diurno + $value->ftes_diurno;
                                $total_ftes_variable_nocturno = $total_ftes_variable_nocturno + $value->ftes_nocturno;
                                $total_servicio_variable = $total_servicio_variable + $value->valor_mes;

                            }else{

                                $total_ftes_variable = $total_ftes_variable - $value->ftes;
                                $total_ftes_variable_diurno = $total_ftes_variable_diurno - $value->ftes_diurno;
                                $total_ftes_variable_nocturno = $total_ftes_variable_nocturno - $value->ftes_nocturno;
                                $total_servicio_variable = $total_servicio_variable - $value->valor_mes;
                            }

                            ?>
                            <td>
                                <?='$ '.number_format($value->valor_mes, 0, '.', '.').' COP'?>
                            </td>
                            <td>
                                <a href="#" onclick="eliminar('<?=$value->id?>');return false;">
                                    <i class="fa fa-trash"></i>Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } 
                    } ?>
                    <tr>           
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong><?=$total_ftes_variable?></strong></td>
                        <td></td>
                        <td> 
                            <?='$ '.number_format($total_servicio_variable, 0, '.', '.').' COP'?>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<table class="table">
    <tr>
        <td><b>Total Ftes Fijos Proporcional</b></td>
        <td><?=$ftes_fijo_proporcional?></td>
        <td><b>Total Valor de Servicios Fijos Proporcional</b></td>
        <td><?='$ '.number_format($total_fijo_proporcional, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Total Ftes de Servicios Adicionales</b></td>
        <td><?=$ftes_adicinonal?></td>
        <td><b>Total Valor de Servicios Adicionales</b></td>
        <td><?='$ '.number_format($total_adicional, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Total Ftes en Recargo Nocturno</b></td>
        <td><?=$ftes_recargo_nocturno?></td>
        <td><b>Total Valor de Recargo Nocturno</b></td>
        <td><?='$ '.number_format($total_recargo_nocturno, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Total Ftes por Judicializacion</b></td>
        <td><?=$ftes_judicial?></td>
        <td><b>Total Valor por Judicializacion</b></td>
        <td><?='$ '.number_format($total_judicial, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Total Ftes de Servicios No Prestados</b></td>
        <td><?=$ftes_noprestados?></td>
        <td><b>Total valor de Servicios No Prestados</b></td>
        <td><?='$ '.number_format($total_noprestado, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Sub-Total de FTES Fijos Diurnos</b></td>
        <td><?=$total_ftes_fijos_diurnos?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Sub-Total de FTES Fijos Nocturnos</b></td>
        <td><?=$total_ftes_fijos_nocturnos?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Sub-Total de FTES Fijos</b></td>
        <td><?=$total_ftes_fijos?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Sub-Total de FTES Variables</b></td>
        <td><?=$total_ftes_variable?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Total de FTES</b></td>
        <td><?=($total_ftes_fijos+$total_ftes_variable)?></td>
        <td><b>Total del Servicio</b></td>
        <td><?='$ '.number_format(($total_servicio_fijo+$total_servicio_variable), 0, '.', '.').' COP'?></td>
    </tr>
</table>
<?php if($model->estado=='abierto'){?>
<script type="text/javascript">
    function actualizar(){
        var url="<?php echo Url::toRoute('prefactura-fija/update')?>";
        var r = confirm('¿Desea Finalizar la Pre-factura?');
        if (r == true) {
            $.ajax({
                url: url,
                type:'POST',
                dataType:"json",
                cache:false,
                data: {
                    id: <?=$model->id?>
                },
                beforeSend:  function() {
                    $('#info').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                },
                success: function(data){
                    if(data.respuesta=='true'){
                        location.href="<?php echo Url::toRoute('prefactura-fija/view')?>"+"?id="+"<?=$model->id?>";
                    }else{
                        $("#info").html('<div class="alert alert-danger alert-dismissable">'+
                                          '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                          '<strong>Alerta!</strong> No se pudo Finalizar la Prefactura. '+data.respuesta+
                                        '</div>'
                                        );
                    }
                    $("#info").html('');
                }
            });
        }
    }
    function eliminar(id){
        var r = confirm("¿Seguro desea Eliminar este Dispositivo?");
        if (r == true) {
            location.href="<?php echo Url::toRoute('prefactura-fija/delete-prefactura-dispositivo?id=');?>"+id+"&prefactura=<?=$model->id?>";
        }
    }
</script>
<?php }?>
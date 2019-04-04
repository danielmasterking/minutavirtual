<?php
use yii\helpers\Url;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$styletd='style="padding: 5px;text-align: center;font-size: 9px;"';
$styletd2='style="padding: 5px;font-size: 10px;"';
$styleth='style="padding: 5px;text-align: center;font-size: 9px;';
date_default_timezone_set ( 'America/Bogota');
?>
<h3 style="text-align: center;font-size: 16px;">Pre-factura <?=$model->fkDependencia->nombre?> mes de <?=strtoupper ($meses[$model->mes-1]);?> de <?=$model->ano?></h3>
<table style="width: 100%;border-collapse: collapse;">
    <tr>
        <td <?=$styletd2?> ><b>MES DE FACTURACION:</b></td>
        <td <?=$styletd2?> ><?=strtoupper ($meses[$model->mes-1]);?></td>
        <td <?=$styletd2?> ><b>REGIONAL:</b></td>
        <td <?=$styletd2?> ><?=strtoupper ($model->regional);?></td>
        <td rowspan="5">
            <img src="<?=$model->fkEmpresa->logo?>" width="200" width="110"/>
        </td>
    </tr>
    <tr>
        <td <?=$styletd2?> ><b>EMPRESA DE SEGURIDAD:</b></td>
        <td <?=$styletd2?> colspan="3"><?=$model->fkEmpresa->nombre?></td>
    </tr>
    <tr>
        <td <?=$styletd2?> ><b>CIUDAD:</b></td>
        <td <?=$styletd2?> ><?=strtoupper ($model->ciudad);?></td>
        <td <?=$styletd2?> ><b>MARCA:</b></td>
        <td <?=$styletd2?> ><?=strtoupper ($model->marca);?></td>
    </tr>
    <tr>
        <td <?=$styletd2?> ><b>DEPENDENCIA:</b></td>
        <td <?=$styletd2?> ><?=$model->fkDependencia->nombre?></td>
        <td <?=$styletd2?> ><b>CEBE:</b></td>
        <td <?=$styletd2?> ><?=$model->fkDependencia->cebe?></td>
    </tr>
    <tr>
        <td <?=$styletd2?> ><b>FECHA:</b></td>
        <td <?=$styletd2?> ><?= date('Y-m-d') ?></td>
        <td <?=$styletd2?> ><b>CECO:</b></td>
        <td <?=$styletd2?> ><?=$model->fkDependencia->ceco?></td>
    </tr>
</table>
<br>
<h2 style="text-align: center;font-size: 16px;">Dispositivos Fijos</h2>
<table style="width: 100%;border-collapse: collapse;">
    <thead>
        <tr>
            <th <?=$styleth.'width:15%;"'?> >Servicio</th>
            <th <?=$styleth.'width:15%;"'?> >Puesto</th>
            <th <?=$styleth.'"'?> >Cant</th>
            <th <?=$styleth.'"'?> >Jornada (Horas)</th>
            <th <?=$styleth.'"'?> >Desde</th>
            <th <?=$styleth.'"'?> >Hasta</th>
            <th <?=$styleth.'"'?> >L</th>
            <th <?=$styleth.'"'?> >M</th>
            <th <?=$styleth.'"'?> >M</th>
            <th <?=$styleth.'"'?> >J</th>
            <th <?=$styleth.'"'?> >V</th>
            <th <?=$styleth.'"'?> >S</th>
            <th <?=$styleth.'"'?> >D</th>
            <th <?=$styleth.'"'?> >F</th>      
            <th <?=$styleth.'"'?> >% de Cobro</th>
            <th <?=$styleth.'"'?> >FTES</th>
            <th <?=$styleth.'"'?> >Total Días</th>
            <th <?=$styleth.'width:15%;"'?> >$/Mes</th>
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
            <td <?=$styletd?> ><?=$value->servicio->servicio->nombre.'-'.$value->servicio->descripcion?></td>
            <td <?=$styletd?> ><?=$value->puesto->nombre?></td>
            <td <?=$styletd?> ><?=$value->cantidad_servicios?></td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->horas);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->hora_inicio);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->hora_fin);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> ><?=$value->lunes?></td>
            <td <?=$styletd?> ><?=$value->martes?></td>
            <td <?=$styletd?> ><?=$value->miercoles?></td>
            <td <?=$styletd?> ><?=$value->jueves?></td>
            <td <?=$styletd?> ><?=$value->viernes?></td>
            <td <?=$styletd?> ><?=$value->sabado?></td>
            <td <?=$styletd?> ><?=$value->domingo?></td>
            <td <?=$styletd?> ><?=$value->festivo?></td>
            <td <?=$styletd?> ><?=$value->porcentaje?></td>
            <td <?=$styletd?> ><?=$value->ftes?></td>
            <td <?=$styletd?> ><?=$value->total_dias?></td>
            <?php
                $total_ftes_fijos = $total_ftes_fijos + $value->ftes;
                $total_ftes_fijos_diurnos = $total_ftes_fijos_diurnos + $value->ftes_diurno;
                $total_ftes_fijos_nocturnos = $total_ftes_fijos_nocturnos + $value->ftes_nocturno;
                $total_servicio_fijo = $total_servicio_fijo + $value->valor_mes;
            ?>
            <td <?=$styletd?> >
                <?='$ '.number_format($value->valor_mes, 0, '.', '.').' COP'?>
            </td>
        </tr>
    <?php } 
    } ?>
    <tr>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>   
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ><strong><?=$total_ftes_fijos?></strong></td>
        <td <?=$styletd?> ></td>      
        <td <?=$styletd?> >
            <?='$ '.number_format($total_servicio_fijo, 0, '.', '.').' COP'?>
        </td> 
    </tr>
</table>
<br>
<h2 style="text-align: center;font-size: 16px;">Dispositivos Variable</h2>
<table style="width: 100%;border-collapse: collapse;">
    <thead>
        <tr>
            <th <?=$styleth.'width:15%;"'?> >Servicio</th>
            <th <?=$styleth.'width:15%;"'?> >Puesto</th>
            <th <?=$styleth.'"'?> >Cant</th>
            <th <?=$styleth.'"'?> >Jornada (Horas)</th>
            <th <?=$styleth.'"'?> >Servicio(Tipo)</th>
            <th <?=$styleth.'"'?> >Desde</th>
            <th <?=$styleth.'"'?> >Hasta</th> 
            <th <?=$styleth.'"'?> >% de Cobro</th>
            <th <?=$styleth.'"'?> >FTES</th>
            <th <?=$styleth.'"'?> >Total Días</th>
            <th <?=$styleth.'width:15%;"'?> >$/Mes</th>
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
                //$ftes_recargo_nocturno = $ftes_recargo_nocturno + $value->ftes;
                //$total_recargo_nocturno = $total_recargo_nocturno + $value->valor_mes;

                $ftes_judicial = $ftes_judicial + $value->ftes;
                $total_judicial = $total_judicial + $value->valor_mes;

            }else if($value->tipo_servicio=='Recargo Nocturno'){
                //$ftes_judicial = $ftes_judicial + $value->ftes;
                //$total_judicial = $total_judicial + $value->valor_mes;

                $ftes_recargo_nocturno = $ftes_recargo_nocturno + $value->ftes;
                $total_recargo_nocturno = $total_recargo_nocturno + $value->valor_mes;

            }else if($value->tipo_servicio=='No Prestado'){
                $ftes_noprestados = $ftes_noprestados + $value->ftes;
                $total_noprestado = $total_noprestado + $value->valor_mes;
            }
        ?>
        <tr>
            <td <?=$styletd?> ><?=$value->servicio->servicio->nombre.'-'.$value->servicio->descripcion?></td>
            <td <?=$styletd?> ><?=$value->puesto->nombre?></td>
            <td <?=$styletd?> ><?=$value->cantidad_servicios?></td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->horas);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> ><?=$value->tipo_servicio?></td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->hora_inicio);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> >
            <?php
                $date = new DateTime($value->hora_fin);
                echo $date->format('H:i');
            ?>
            </td>
            <td <?=$styletd?> ><?=$value->porcentaje?></td>
            <td <?=$styletd?> ><?=$value->ftes?></td>
            <td <?=$styletd?> ><?=$value->total_dias?></td>
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
            <td <?=$styletd?> >
                <?='$ '.number_format($value->valor_mes, 0, '.', '.').' COP'?>
            </td>
        </tr>
    <?php } 
    } ?>
    <tr>           
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ></td>
        <td <?=$styletd?> ><strong><?=$total_ftes_variable?></strong></td>
        <td <?=$styletd?> ></td>         
        <td <?=$styletd?> >
            <?='$ '.number_format($total_servicio_variable, 0, '.', '.').' COP'?>
        </td> 
    </tr>
</table>
<br>
<table style="width: 100%;border-collapse: collapse;">
    <tr>
        <td <?=$styleth.'"'?> ><b>Total Ftes Fijos Proporcional</b></td>
        <td <?=$styleth.'"'?> ><?=$ftes_fijo_proporcional?></td>
        <td <?=$styleth.'"'?> ><b>Total Valor de Servicios Fijos Proporcional</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format($total_fijo_proporcional, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Total Ftes de Servicios Adicionales</b></td>
        <td <?=$styleth.'"'?> ><?=$ftes_adicinonal?></td>
        <td <?=$styleth.'"'?> ><b>Total Valor de Servicios Adicionales</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format($total_adicional, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Total Ftes en Recargo Nocturno</b></td>
        <td <?=$styleth.'"'?> ><?=$ftes_recargo_nocturno?></td>
        <td <?=$styleth.'"'?> ><b>Total Valor de Recargo Nocturno</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format($total_recargo_nocturno, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Total Ftes por Judicializacion</b></td>
        <td <?=$styleth.'"'?> ><?=$ftes_judicial?></td>
        <td <?=$styleth.'"'?> ><b>Total Valor por Judicializacion</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format($total_judicial, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Total Ftes de Servicios No Prestados</b></td>
        <td <?=$styleth.'"'?> ><?=$ftes_noprestados?></td>
        <td <?=$styleth.'"'?> ><b>Total valor de Servicios No Prestados</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format($total_noprestado, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ></td>
        <td <?=$styleth.'"'?> ></td>
        <td <?=$styleth.'"'?> ></td>
        <td <?=$styleth.'"'?> ></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Sub-Total de FTES Fijos Diurnos</b></td>
        <td <?=$styleth.'"'?> ><?=$total_ftes_fijos_diurnos?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Sub-Total de FTES Fijos Nocturnos</b></td>
        <td <?=$styleth.'"'?> ><?=$total_ftes_fijos_nocturnos?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Sub-Total de FTES Fijos</b></td>
        <td <?=$styleth.'"'?> ><?=$total_ftes_fijos?></td>
        <td <?=$styleth.'"'?> ></td>
        <td <?=$styleth.'"'?> ></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Sub-Total de FTES Variables</b></td>
        <td <?=$styleth.'"'?> ><?=$total_ftes_variable?></td>
        <td <?=$styleth.'"'?> ></td>
        <td <?=$styleth.'"'?> ></td>
    </tr>
    <tr>
        <td <?=$styleth.'"'?> ><b>Total de FTES</b></td>
        <td <?=$styleth.'"'?> ><?=($total_ftes_fijos+$total_ftes_variable)/*-$ftes_noprestados*/?></td>
        <td <?=$styleth.'"'?> ><b>Total del Servicio</b></td>
        <td <?=$styleth.'"'?> ><?='$ '.number_format(($total_servicio_fijo+$total_servicio_variable)/*-$total_noprestado*/, 0, '.', '.').' COP'?></td>
    </tr>
</table>
<br><br>
<br>
<table style="width: 100%;border:0px;">
    <tr>
        <td style="text-align: center;border:0px;width: 50%;font-size: 10px;">
            <hr style="width: 90%;">
            <b>VBO. ADMINISTRADOR</b>
        </td>
        <td style="text-align: center;border:0px;width: 50%;font-size: 10px;">
            <hr style="width: 90%;">
            <b>VBO. SEGURIDAD</b>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;border:0px;width: 50%;font-size: 10px;">
            <hr style="width: 90%;">
            <b>VBO. EMPRESA SEGURIDAD</b>
        </td>
        <td style="text-align: center;border:0px;width: 50%;font-size: 10px;">
            <hr style="width: 90%;">
            <b>VBO. COORD. SEGURIDAD</b>
        </td>
    </tr>
</table>
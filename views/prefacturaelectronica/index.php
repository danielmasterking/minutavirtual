<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\widgets\Select2;

$this->title = 'Listado de Pre-facturas electronicas';
$this->params['breadcrumbs'][] = $this->title;
$ciudades_zonas = array();//almacena las regionales permitidas al usuario

foreach($zonasUsuario as $zona){
    $ciudades_zonas [] = $zona->zona->ciudades;
}
$ciudades_permitidas = array();
foreach($ciudades_zonas as $ciudades){
    foreach($ciudades as $ciudad){
        $ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
    }
}

$marcas_permitidas = array();
$data_marcas=array();
foreach($marcasUsuario as $marca){
    $marcas_permitidas [] = $marca->marca_id;
    $data_marcas [$marca->marca->nombre] = $marca->marca->nombre;
}


$empresas_permitidas = array();
foreach($empresasUsuario as $empresa){
    $empresas_permitidas [] = $empresa->nit;
}
$data_dependencias = array();
foreach($dependencias as $dependencia){
    if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ){
        if(in_array($dependencia->marca_id,$marcas_permitidas) ){
            //if(in_array($dependencia->empresa,$empresas_permitidas) ){
                $data_dependencias[$dependencia->nombre] =  $dependencia->nombre;
            //}
        }
    }
}
?>
<div class="prefactura-fija-index">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <a href="<?php echo Url::toRoute('prefactura-fija/ventana_inicio')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver a Prefactura
    </a>

    <a href="<?php echo Url::toRoute('prefacturaelectronica/create')?>" class="btn btn-primary">
        <i class="fa fa-file"></i> Crear Prefactura
    </a>
    <?php 

    $flashMessages = Yii::$app->session->getAllFlashes();
    if ($flashMessages) {
        echo "<br><br>";
        foreach($flashMessages as $key => $message) {
            echo "<div class='alert alert-" . $key . " alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    $message
                </div>";   
        }
    }
?>
    <br><br>
    <form id="form_excel" method="post" action="<?php echo Url::toRoute('prefacturaelectronica/index')?>">
        <div class="row">
            <!--<div class="navbar-form navbar-right" role="search">-->
                <div class="col-md-3">
                    <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar Coincidencias">
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <select id="ordenado" name="ordenado" class="form-control">
                        <option value="">[ORDENAR POR...]</option>
                        <option value="fecha">Fecha</option>
                        <option value="mes">Mes</option>
                        <option value="ano">Año</option>
                        <option value="dependencia">Dependencia</option>
                        <option value="empresa">Empresa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="forma" name="forma" class="form-control">
                        <option value="">[FORMA...]</option>
                        <option value="SORT_ASC">Ascendente</option>
                        <option value="SORT_DESC">Descendente</option>
                    </select>
                </div>
            <!--</div>-->
        </div>
        <br>
        <div class="row">
            <!--<div class="navbar-form navbar-right" role="search">-->

                <div class="col-md-4">
                    <?php 
                        echo Select2::widget([
                            'id' => 'marcas2',
                            'name' => 'marcas2',
                            'value' => '',
                            'data' => $data_marcas,
                            'options' => ['multiple' => false, 'placeholder' => 'POR MARCA...']
                        ]);
                    ?>
                </div>



                <div class="col-md-4">
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
                <div class="col-md-4">
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
            <!--</div>-->
        </div>

         <br>
        <div class="row">
            <div class="col-md-6" >
                
                <select class="form-control" id="mes" name="mes">
                    <option value="">Por Mes</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>

                </select>
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
        <hr>
        <div id="info"></div>
        <div id="partial"><?=$partial?></div>
    </div>
</div>

<script>
    function eliminar(id){
        var url="<?php echo Url::toRoute('prefacturaelectronica/delete')?>";
        var r = confirm('¿Desea eliminar la Pre-factura?');
        if (r == true) {
            location.href=url+"?id="+id;
        }
    }
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
        var marca=$("#marcas2").val();
        var mes=$("#mes").val();
        $.ajax({
            url:"<?php echo Url::toRoute('prefacturaelectronica/index')?>",
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
                page: page,
                marca:marca,
                mes:mes
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
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MinutaHumanaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte Ingreso y Salida';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minuta-humana-index">

    <a href="<?php echo Url::toRoute('minutahumana/ventanainicio')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver 
    </a>

    <h1><?= Html::encode($this->title) ?></h1>

    <form id="form_excel" method="post" action="<?php echo Url::toRoute('minutahumana/index')?>">
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
                            //'value' => '',
                            'data' => $list_dependencia,
                            'options' => ['multiple' => false, 'placeholder' => 'POR DEPENDENCIA...']
                        ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <select id="ordenado" name="ordenado" class="form-control">
                        <option value="">[ORDENAR POR...]</option>
                        <option value="fecha">Fecha</option>
                        <option value="dependencia">Dependencia</option>
                        <option value="puesto">Puesto</option>
                        <option value="cedula">Cedula</option>
                    
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

         
    </form>

    <div class="row">
        <div class="navbar-form navbar-right" role="search">
            <button type="submit" class="btn btn-primary" onclick="excel()">
                <i class="fa fa-file-excel-o fa-fw"></i> Descargar Busqueda en Excel
            </button>

             <button type="submit" class="btn btn-primary" onclick="pdf()">
                <i class="fa fa-file-pdf-o fa-fw"></i> Descargar Busqueda en pdf 
            </button>

            <button type="submit" class="btn btn-primary" onclick="consultar(0)">
                <i class="fa fa-search fa-fw"></i> Buscar
            </button>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   <div class="row">
        <hr>
        <div id="info"></div>
        <div id="partial"><?=$partial?></div>
    </div>
</div>


<script type="text/javascript">
    
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
        var dependecia=$("#dependencias2 option:selected").val();
        
        $.ajax({
            url:"<?php echo Url::toRoute('minutahumana/index')?>",
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

    function pdf(){
        var desde=$('#desde').val();
        var hasta=$('#hasta').val();
        var buscar=$("#buscar").val();
        var ordenado=$("#ordenado").val();
        var forma=$("#forma").val();
        var dependecia=$("#dependencias2").val();

        window.open('<?php echo Url::toRoute('minutahumana/imprimir')?>?desde='+desde+'&hasta='+hasta+'&buscar='+buscar+'&ordenado='+ordenado+'&forma='+forma+'&dependecia='+dependecia,'_blank');
    }

</script>
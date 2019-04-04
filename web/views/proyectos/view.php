<?php
use yii\helpers\Html;
use kartik\date\DatePicker;
$this->title = 'Detalle '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Analises', 'url' => ['index']];
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li><?=$this->title?></li>
</ol>
<h3 style="text-align: center;"><?= Html::encode($this->title) ?></h3>
<table class="table table-striped">
    <tr>
        <td style="width: 25%;"><b>Presupuesto Total</b></td>
        <td style="width: 25%;"><?='$'.number_format($model->presupuesto_total, 0, '.', '.').' COP'?></td>
        <td style="width: 25%;"><b>Suma Total</b></td>
        <td style="width: 25%;"><?='$'.number_format($model->suma_total, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Presupuesto Seguridad</b></td>
        <td><?='$'.number_format($model->presupuesto_seguridad, 0, '.', '.').' COP'?></td>
        <td><b>Suma Seguridad</b></td>
        <td><?='$'.number_format($model->suma_seguridad, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Presupuesto Riesgo</b></td>
        <td><?='$'.number_format($model->presupuesto_riesgo, 0, '.', '.').' COP'?></td>
        <td><b>Suma Riesgo</b></td>
        <td><?='$'.number_format($model->suma_riesgo, 0, '.', '.').' COP'?></td>
    </tr>
    <tr>
        <td><b>Presupuesto Heas</b></td>
        <td><?='$'.number_format($model->presupuesto_heas, 0, '.', '.').' COP'?></td>
        <td><b>Suma Heas</b></td>
        <td><?='$'.number_format($model->suma_heas, 0, '.', '.').' COP'?></td>
    </tr>
</table>
<h4>Detalle de Pedidos</h4>
<hr>
<ul class="nav nav-tabs nav-justified">
    <li id="normal" class="active">
        <a href="#" id="link_normal" onclick="return false;">Normales</a>
    </li>
    <li id="especial" class="">
        <a href="#" id="link_especial" onclick="return false;">Especiales</a>
    </li>
</ul>
<hr>
<form id="form_excel" method="post">
   <div class="row">
        <div class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar Coincidencias">
            </div>
            <div class="form-group">
                <select id="ordenado" name="ordenado" class="form-control">
                    <option value="">[ORDENAR POR...]</option>
                    <option value="fecha">Fecha</option>
                    <option value="repetido">Repetido</option>
                    <option value="producto">Producto</option>
                    <option value="cantidad">Cantidad</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="solicitante">Solicitante</option>
                </select>
            </div>
            <div class="form-group">
                <select id="forma" name="forma" class="form-control">
                    <option value="">[FORMA...]</option>
                    <option value="SORT_ASC">Ascendente</option>
                    <option value="SORT_DESC">Descendente</option>
                </select>
            </div>
        </div>
   </div>
   <div class="row">
        <div class="navbar-form navbar-right" role="search">
            <div class="form-group">
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
            <div class="form-group">
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
<div id="info"></div>

<div id="partial"></div>
<script>
    var url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-normales'; ?>";
    var normal=false;
    var especial=false;
    $(document).on("click", "#link_normal, #normal", function(){
        $("#normal").addClass("active");
        $("#especial").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-normales'; ?>";
        if(!normal){
            normal=true;especial=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on("click", "#link_especial, #especial", function(){
        $("#especial").addClass("active");
        $("#normal").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-especial'; ?>";
        if(!especial){
            especial=true;normal=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on( "click", "#partial .pagination li", function() {
        var page = $(this).attr('p');
        consultar(page);
    });
    function consultar(page){
        $("#partial").html('');
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
        $.ajax({
            url:url,
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                desde: desde,
                hasta: hasta,
                buscar: buscar,
                ordenado: ordenado,
                forma: forma,
                proyecto: <?php echo $model->id?>,
                page: page
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
        input = document.createElement('input');
        input.type = 'hidden';
        input.id = 'proyecto';
        input.name = 'proyecto';
        input.value = '<?php echo $model->id?>';
        form.appendChild(input);
        form.action=url;
        form.submit();
    }
    function limpiar(){
        $("#buscar").val('')
        $("#ordenado").val('')
        $("#forma").val('')
        $("#desde").val('')
        $("#hasta").val('')
    }
    consultar(0);
    normal=true;especial=false;
</script>
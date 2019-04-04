<?php
use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

MaskMoney::widget([
    'name' => 'xxxx',
    'value' => 20322.22
]);
$this->title = 'Detalle de Presupuesto - '.$model->cecoo->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Analises', 'url' => ['index']];
$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
    $permisos = Yii::$app->session['permisos-exito'];
}
$total_iva=0;
$total_iva_seguridad=0;
$total_iva_riesgo=0;
$total_iva_activo=0;
$total_iva_gasto=0;
?>

<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li><?=$this->title?></li>
</ol>
<a href="<?php echo Url::toRoute('proyectos/index')?>" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i>
</a>

<div class="row">
    <div class="col-md-12">
        <h3 style="text-align: center;"><?= Html::encode($this->title) ?></h3>
        <?php 

            $flashMessages = Yii::$app->session->getAllFlashes();
            if ($flashMessages) {
                foreach($flashMessages as $key => $message) {
                    echo "<div class='alert alert-" . $key . " alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            $message
                        </div>";   
                }
            }
        ?>



        <button onclick="tableToExcel('testTable', 'W3C Example Table')" class="btn btn-primary">
        <i class="fa fa-file-excel-o"></i> 
        Exportar</button>
        <table class="table table-striped" id="testTable">
            <th>
                <?php 
                    if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
                    <td style="width: 25%;font-weight: bold;">Presupuesto</td>
                    <td style="width: 25%;font-weight: bold;">Total Sin IVA</td>
                    <!-- <td style="width: 25%;font-weight: bold;">Total Con IVA</td> -->
                <?php } ?>
                <td style="width: 25%;font-weight: bold;">Saldo</td>
                <?php 
                    if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
                    <td style="width: 25%;font-weight: bold;">Total Con IVA</td>
                <?php } ?>
                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>

                <td style="width: 25%;font-weight: bold;">Total Metros2</td>

                <?php endif;?>
                <td style="width: 12%;"></td>
            </th>
            <tr>
                <td><b>Total</b></td>
                <?php 
                $total_iva=(($model->suma_total*$model->iva)/100)+$model->suma_total;
                if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){
                    ?>
                    <td><?='$ '.number_format($model->presupuesto_total, 0, '.', '.').' COP'?></td>
                    <td id="suma_total"><?='$ '.number_format($model->suma_total, 0, '.', '.').' COP'?></td>
                    <td id="saldo_total">
                    <?php 
                    if(($model->presupuesto_total-$total_iva)<0){
                        echo '<b style="color:red;">$ '.number_format(($model->presupuesto_total-$total_iva), 0, '.', '.').'</b> COP';
                    }else{
                        echo '<b style="color:green;">$ '.number_format(($model->presupuesto_total-$total_iva), 0, '.', '.').'</b> COP';
                    }
                    ?>  
                    </td>
                <?php } ?>
                <td id="total_iva">

                    <?php
                    
                    echo '$ '.number_format($total_iva, 0, '.', '.').' COP'?>
                </td>

                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>

                <td id='total_m2'>
                    <?php 
                        if ($model->metros_cuadrados!='') {
                            $total_m2=($total_iva/$model->metros_cuadrados);
                            echo '$ '.number_format($total_m2, 0, '.', '.').' COP';    
                        }
                        

                    ?>
                </td>

                <?php endif;?>

                <td id="money-total">
                    <?php 
                    if($model->presupuesto_total<$total_iva){
                        echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
                    }else{
                        echo '<i class="fa fa-money" style="color:green;"></i>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Seguridad</b></td>
                <?php 
                $total_iva_seguridad=(($model->suma_seguridad*$model->iva)/100)+$model->suma_seguridad;
                if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){
                    
                    ?>
                    <td><?='$ '.number_format($model->presupuesto_seguridad, 0, '.', '.').' COP'?></td>
                    <td id="suma_seguridad"><?='$ '.number_format($model->suma_seguridad, 0, '.', '.').' COP'?></td>
                    <td id="saldo_seguridad">
                    <?php 
                    if(($model->presupuesto_seguridad-$total_iva_seguridad)<0){
                        echo '<b>$ '.number_format(($model->presupuesto_seguridad-$total_iva_seguridad), 0, '.', '.').'</b> COP';
                    }else{
                        echo '<b>$ '.number_format(($model->presupuesto_seguridad-$total_iva_seguridad), 0, '.', '.').'</b> COP';
                    }
                    ?>  
                    </td>
                <?php } ?>
                <td id="total_iva_seguridad">
                    <?php
                    echo '$ '.number_format($total_iva_seguridad, 0, '.', '.').' COP'?>
                </td>

                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>
                <td>
                    
                </td>
                <?php endif;?>

                <td id="money-seguridad">
                    <?php 
                    if($model->presupuesto_seguridad<$total_iva_seguridad){
                        //echo '<i class="fa fa-money fa-2x" ></i>';
                    }else{
                        //echo '<i class="fa fa-money" ></i>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Riesgo</b></td>
                <?php 
                $total_iva_riesgo=(($model->suma_riesgo*$model->iva)/100)+$model->suma_riesgo;
                if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){
                    
                    ?>
                    <td><?='$ '.number_format($model->presupuesto_riesgo, 0, '.', '.').' COP'?></td>
                    <td id="suma_riesgo"><?='$ '.number_format($model->suma_riesgo, 0, '.', '.').' COP'?></td>
                    <td id="saldo_riesgo">
                    <?php 
                    if(($model->presupuesto_riesgo-$total_iva_riesgo)<0){
                        echo '<b >$ '.number_format(($model->presupuesto_riesgo-$total_iva_riesgo), 0, '.', '.').'</b> COP';
                    }else{
                        echo '<b >$ '.number_format(($model->presupuesto_riesgo-$total_iva_riesgo), 0, '.', '.').'</b> COP';
                    }
                    ?>  
                    </td>
                <?php } ?>
                <td id="total_iva_riesgo">

                    <?php
                    echo '$ '.number_format($total_iva_riesgo, 0, '.', '.').' COP'?>
                </td>

                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>
                <td>
                    

                </td>
            <?php endif;?>

                <td id="money-riesgo">
                    <?php 
                    if($model->presupuesto_riesgo<$total_iva_riesgo){
                        //echo '<i class="fa fa-money fa-2x" ></i>';
                    }else{
                        //echo '<i class="fa fa-money" ></i>';
                    }
                    ?>
                </td>
            </tr>
            <!--<tr>
                <th></th>
                <th>Preestablecido para...</th>
                <th>Neto</th>
                <th>Total Con IVA</th>
                <th>Saldo</th>
                <th></th>
            </tr>-->
            <tr>
                <td><b>Activo</b></td>
                <?php 
                $total_iva_activo=(($model->suma_activo*$model->iva)/100)+$model->suma_activo;
                if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){
                    ?>
                    <td><?='$ '.number_format($model->presupuesto_activo, 0, '.', '.').' COP'?></td>
                    <td id="suma_activo"><?='$ '.number_format($model->suma_activo, 0, '.', '.').' COP'?></td>
                    <td id="saldo_activo">
                    <?php 
                    if(($model->presupuesto_activo-$total_iva_activo)<0){
                        echo '<b style="color:red;">$ '.number_format(($model->presupuesto_activo-$total_iva_activo), 0, '.', '.').'</b> COP';
                    }else{
                        echo '<b style="color:green;">$ '.number_format(($model->presupuesto_activo-$total_iva_activo), 0, '.', '.').'</b> COP';
                    }
                    ?>  
                    </td>
                <?php } ?>
                <td id="total_iva_activo">
                    <?php
                    echo '$ '.number_format($total_iva_activo, 0, '.', '.').' COP'?>
                </td>

                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>
                <td>
                    
                </td>
            <?php endif;?>
                <td id="money-activo">
                    <?php 
                    /*if($model->presupuesto_activo<$total_iva_activo){
                        echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
                    }else{
                        echo '<i class="fa fa-money" style="color:green;"></i>';
                    }*/
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Gasto</b></td>
                <?php 
                $total_iva_gasto=(($model->suma_gasto*$model->iva)/100)+$model->suma_gasto;
                if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){
                    ?>
                    <td><?='$ '.number_format($model->presupuesto_gasto, 0, '.', '.').' COP'?></td>
                    <td id="suma_gasto"><?='$ '.number_format($model->suma_gasto, 0, '.', '.').' COP'?></td>
                    <td id="saldo_gasto">
                    <?php 
                    if(($model->presupuesto_gasto-$total_iva_gasto)<0){
                        echo '<b style="color:red;">$ '.number_format(($model->presupuesto_gasto-$total_iva_gasto), 0, '.', '.').'</b> COP';
                    }else{
                        echo '<b style="color:green;">$ '.number_format(($model->presupuesto_gasto-$total_iva_gasto), 0, '.', '.').'</b> COP';
                    }
                    ?>  
                    </td>
                <?php } ?>
                <td id="total_iva_gasto">
                    <?php
                    echo '$ '.number_format($total_iva_gasto, 0, '.', '.').' COP'?>
                </td>

                <?php if(in_array("presupuesto_ver_metros_cuadrados", $permisos)):?>
                <td>
                    
                </td>
                <?php endif;?>

                <td id="money-gasto">
                    <?php 
                    if($model->presupuesto_gasto<$total_iva_gasto){
                        echo '<i class="fa fa-money fa-2x" style="color:red;"></i>';
                    }else{
                        echo '<i class="fa fa-money" style="color:green;"></i>';
                    }
                    ?>
                </td>
            </tr>
        </table>
        
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php 
        if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos) || in_array("coordinador", $permisos)){?>
            <div id="info_procesar"></div>
            <button id="procesar" type="submit" class="btn btn-primary lock" onclick="procesar()">
                Procesar Saldo Pedidos
            </button>
        <?php } ?>
    </div>
    <div class="col-md-4">
        <?php 
        if(in_array("coordinador", $permisos) || in_array("administrador", $permisos)){?>
            <div id="info_bloquear_presupuesto"></div>
            <button id="bloquear_presupuesto" type="submit" class="btn btn-danger lock" onclick="cambiarEstadoPresupuesto()">
                <?php if($model->estado=='ABIERTO'){?>
                <i class="fa fa-unlock"></i>
                BLOQUEAR PRESUPUESTO
                <?php }else if($model->estado=='CERRADO'){ ?>
                <i class="fa fa-lock"></i>
                DESBLOQUEAR PRESUPUESTO
                <?php } ?>
            </button>
        <?php } ?>
    </div>
    <div class="col-md-4">
        <?php 
        if(in_array("coordinador", $permisos) || in_array("administrador", $permisos)){?>
            <div id="info_cerrar_presupuesto"></div>
            <button id="cerrar_presupuesto" type="submit" class="btn btn-danger lock" onclick="cerrarPresupuesto()" disabled="">
                <i class="fa fa-check"></i>
                ENVIAR A PEDIDOS
            </button>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <h3 style="text-align: center;">Historia Transacciones</h3>
        <table class="table table-striped">
            <tr>
                <th>Seguridad</th>
                <th>Riesgo</th>
                <th>Fecha</th>
            </tr>
            <?php foreach ($presupuestos as $key) {?>
            <tr>
                <td><?='$ '.number_format($key->presupuesto_seguridad, 0, '.', '.').' COP'?></td>
                <td><?='$ '.number_format($key->presupuesto_riesgo, 0, '.', '.').' COP'?></td>
                <td><?=$key->created_on?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <div class="col-md-5">
    <?php if(in_array("revision-financiera", $permisos) || in_array("administrador", $permisos)){?>
        <h3>Guardar Datos</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Orden Interna Gasto(Opex)</label>
                    <input id="orden_interna_gasto" name="orden_interna_gasto" class="form-control lock" placeholder="Orden Interna Gasto" type="text" maxlength="20">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Orden Interna Activo(Capex)</label>
                    <input id="orden_interna_activo" name="orden_interna_activo" class="form-control lock" placeholder="Orden Interna Activo" type="text" maxlength="20">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 ">
                <div class="form-group">
                    <label># Metros cuadrados</label>
                    <input id="m2" name="m2" class="form-control lock" placeholder="Metros cuadrados" type="number" >
                </div>
            </div>


            <div class="col-md-6 ">
                <div class="form-group">
                    <label>IVA</label>
                    <input id="iva" name="iva" class="form-control lock" placeholder="IVA" type="number" maxlength="2"
                    <?php echo !in_array("administrador", $permisos)?'readonly':'';?>
                    >
                </div>
            </div>
        </div>
        <div id="info_guardar_datos"></div>
        <button type="submit" id="guardar_datos" class="btn btn-primary lock" onclick="guardarDatosAdicionales()">
            <i class="fa fa-save"></i> Guardar Datos
        </button>
    <?php } ?>
    </div>
</div>


<h4>Detalle de Pedidos</h4>
<hr>

<?php
 Modal::begin([
  'header' => '<h4>No Aprobado</h4>',
  'id' => 'modal-no-aprobado',
  'size' => 'modal-md',
  ]);
 echo '<div id="info-na"></div>';
 echo '<div class="row">';
     echo '<div class="col-md-8">';
         echo '<label>Indique porque NO se Aprueba</label>';
         echo '<textarea id="motivo-no-aprobado" class="form-control" rows="4" cols="50"></textarea>';
     echo '</div>';
     echo '<div class="col-md-4">';
        echo '<label>Cantidad no Aprobada</label>';
        echo '<select id="cantidad-no-aprobado" class="form-control">';
            echo '<option value="0">[Elija Cantidad]</option>';
        echo '</select>';
     echo '</div>';
 echo '</div>';
 echo '<p>&nbsp;</p>';
 echo '<button onclick="cambiarEstadoNa()" class="btn btn-primary btn-lg">Guardar</button>';
 Modal::end();
?>
<br><br>
<ul class="nav nav-tabs nav-justified">
    <li id="normal" class="active">
        <a href="#" id="link_normal" onclick="return false;">Normales</a>
    </li>
    <li id="especial" class="">
        <a href="#" id="link_especial" onclick="return false;">Especiales</a>
    </li>
    <li id="normal_no_aprobado" class="">
        <a href="#" id="link_normal_no_aprobado" onclick="return false;">Normales No Aprobados</a>
    </li>
    <li id="especial_no_aprobado" class="">
        <a href="#" id="link_especial_no_aprobado" onclick="return false;">Especiales No Aprobados</a>
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
<?php 
    ///Modal Archivos
    Modal::begin([
    'id' => 'modal1',
    'header' => '<h2>Cotizaciones</h2>',
    //'toggleButton' => ['label' => 'Agregar Cotizacion','class'=>'btn btn-primary lock'],
    ]);


    echo"<div id='cotizaciones_'>".
        "</div>";


    Modal::end();
    /////////////////    



    $form = ActiveForm::begin([
        'action'=>'subirarchivo',
        'options'=>['enctype'=>'multipart/form-data'] // important

    ]);




Modal::begin([
    'id' => 'modal',
    'header' => '<h2>Agregar Cotizacion</h2>',
    //'toggleButton' => ['label' => 'Agregar Cotizacion','class'=>'btn btn-primary lock'],
]);
//     echo FileInput::widget([
//     'id' => 'file',
//     'name' => 'file[]',
//     'options'=>[
//         'multiple'=>true
//     ],
//     'pluginOptions' => [
//         'uploadUrl' => Url::to(['/site/file-upload']),
//        'allowedFileExtensions'=>['xls', 'xlsx', 'pdf','jpg','png','gif','jpeg'],
//        'maxFileSize' => 5120,
//        //'maxFileCount' => 10
//     ]
// ]);
   /* echo $form->field($model, 'imageFiles')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    ]);*/
    echo $form->field($model, 'image2[]')->widget(FileInput::classname(), [
            'id' => 'file',
            'options'=>['multiple'=>true],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png','jpeg','docx','xlsx','pdf'],
                               'maxFileSize' => 5120,
              ]
             ]);

    echo  $form->field($proyecto_archivo, 'id_empresa')->widget(Select2::classname(), [
       
       'data' => $empresas,
       'options' => ['placeholder' => 'Selecciona una empresa', ],
    
      ]);




    echo "<input type='hidden' name='presupuesto_id' value='".$model->id."'>";
    echo '<br>';
    // echo '<button type="submit" class="btn btn-primary" onclick="subirCotizacion()">'.
    //         'Subir'.
    //      '</button>';

     echo '<button type="submit" class="btn btn-primary"  data-loading-text="Subiendo..." id="myButton" >'.
            'Subir'.
         '</button>';

Modal::end();



?>
<div id="partial"></div>
<?php ActiveForm::end(); ?>
<div class="modal-process"></div>
<script>
    $('#m2').keyup(function(){
        var total=(<?php echo $total_iva?>/$(this).val());
        if ($(this).val()=='') {
            $("#total_m2").html('');    
        }else{
            $("#total_m2").html('$ '+total.formatPrice()+' COP');
        }
    });


    function cotizaciones(id){
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/cotizaciones_archivos'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                id: id
            },
            beforeSend:  function() {
                $('#cotizaciones_').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
               $('#cotizaciones_').html(data.respuesta);
            }
        });
    }
     $("#w1").submit(function(event) {
            var check=0;

            $('.checkBoxid:checked').each(
                function() {
                    check++;                    
                }
            );   

            if (check<1) {
                alert('Selecciona por lo menos un item');

                return false;
            }
     });
    // $('#myButton').on('click', function () {

       
    //     var $btn = $(this).button('loading');
        
    //     $("#w1").submit();
    //     //$btn.button('reset')
    //     // business logic...
       
    // });


    var tableToExcel = (function() {
          var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
          return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
          }
        })();
    var iva="<?=$model->iva?>";
    $(function() {
        $("#iva").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
        $("#iva").val("<?=$model->iva?>")
        $("#orden_interna_gasto").val("<?=$model->orden_interna_gasto?>")
        $("#orden_interna_activo").val("<?=$model->orden_interna_activo?>")
        $("#m2").val("<?= $model->metros_cuadrados ?>");
        
    });
    var presupuesto_total = parseInt(<?=$model->presupuesto_total?>);
    var presupuesto_seguridad = parseInt(<?=$model->presupuesto_seguridad?>);
    var presupuesto_riesgo = parseInt(<?=$model->presupuesto_riesgo?>);
    var presupuesto_activo = parseInt(<?=$model->presupuesto_activo?>);
    var presupuesto_gasto = parseInt(<?=$model->presupuesto_gasto?>);

    var suma_total = parseInt(<?=$model->suma_total?>);
    var suma_seguridad = parseInt(<?=$model->suma_seguridad?>);
    var suma_riesgo = parseInt(<?=$model->suma_riesgo?>);
    var suma_activo = parseInt(<?=$model->suma_activo?>);
    var suma_gasto = parseInt(<?=$model->suma_gasto?>);

    var orden_interna_gasto = "<?=$model->orden_interna_gasto?>";
    var orden_interna_activo = "<?=$model->orden_interna_activo?>";

    var url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-normales'; ?>";
    var normal=false;
    var especial=false;
    var normal_no_aprobado=false;
    var especial_no_aprobado=false;
    $(document).on("click", "#link_normal, #normal", function(){
        $("#normal").addClass("active");
        $("#especial").removeClass("active");
        $("#normal_no_aprobado").removeClass("active");
        $("#especial_no_aprobado").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-normales'; ?>";
        if(!normal){
            normal=true;especial=false;normal_no_aprobado=false;especial_no_aprobado=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on("click", "#link_especial, #especial", function(){
        $("#especial").addClass("active");
        $("#normal").removeClass("active");
        $("#normal_no_aprobado").removeClass("active");
        $("#especial_no_aprobado").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-especial'; ?>";
        if(!especial){
            especial=true;normal=false;normal_no_aprobado=false;especial_no_aprobado=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on("click", "#link_normal_no_aprobado, #normal_no_aprobado", function(){
        $("#normal_no_aprobado").addClass("active");
        $("#normal").removeClass("active");
        $("#especial").removeClass("active");
        $("#especial_no_aprobado").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-normales?estado=2'; ?>";
        if(!normal_no_aprobado){
            normal_no_aprobado=true;normal=false;especial=false;especial_no_aprobado=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on("click", "#link_especial_no_aprobado, #especial_no_aprobado", function(){
        $("#especial_no_aprobado").addClass("active");
        $("#normal").removeClass("active");
        $("#especial").removeClass("active");
        $("#normal_no_aprobado").removeClass("active");
        url="<?php echo Yii::$app->request->baseUrl . '/proyectos/pedidos-especial?estado=2'; ?>";
        if(!especial_no_aprobado){
            especial_no_aprobado=true;normal_no_aprobado=false;normal=false;especial=false;
            limpiar()
            consultar(0)
        }
    });
    $(document).on( "click", ".checkBoxAll", function() {
        $(".checkBoxid").prop('checked', $(this).prop('checked'));
    });
    $(document).on( "click", ".checkBoxid", function() {
        var exist=false;
        $('.checkBoxid').each(function() {
            if($(this).prop('checked')==false){
                exist=true;return 0;
            }
        });
        if(!exist){
            $(".checkBoxAll").prop('checked', true);
        }else{
            $(".checkBoxAll").prop('checked', false);
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
                <?php if($model->estado=='ENVIADO'){?>
                    $('.lock').prop("disabled", true);
                <?php } ?>
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
    //
    function procesar(){
        var total_iva=0;
        $("#procesar").prop("disabled", true);
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/procesar-presupuestos'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                proyecto: <?php echo $model->id?>
            },
            beforeSend:  function() {
                $('#info_procesar').html('Procesando Pedidos... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                suma_total=parseInt(data.suma_total);
                suma_seguridad=parseInt(data.suma_seguridad);
                suma_riesgo=parseInt(data.suma_riesgo);
                suma_activo=parseInt(data.suma_activo);
                suma_gasto=parseInt(data.suma_gasto);

                alert(suma_activo);
                alert(suma_gasto);


                $("#suma_total").html('$ '+suma_total.formatPrice()+' COP')
                $("#suma_seguridad").html('$ '+suma_seguridad.formatPrice()+' COP')
                $("#suma_riesgo").html('$ '+suma_riesgo.formatPrice()+' COP')
                $("#suma_activo").html('$ '+suma_activo.formatPrice()+' COP')
                $("#suma_gasto").html('$ '+suma_gasto.formatPrice()+' COP')
                total_iva=((suma_total*iva)/100)+suma_total;
                console.log(total_iva)
                if(presupuesto_total<total_iva){
                    $("#money-total").html('<i class="fa fa-money fa-2x" style="color:red;"></i>');
                }else{
                    $("#money-total").html('<i class="fa fa-money" style="color:green;"></i>');
                }
                total_iva_seguridad=((suma_seguridad*iva)/100)+suma_seguridad;
                if(presupuesto_seguridad<total_iva_seguridad){
                    $("#money-seguridad").html('<i class="fa fa-money fa-2x" style="color:red;"></i>');
                }else{
                    $("#money-seguridad").html('<i class="fa fa-money" style="color:green;"></i>');
                }
                total_iva_riesgo=((suma_riesgo*iva)/100)+suma_riesgo;
                if(presupuesto_riesgo<total_iva_riesgo){
                    $("#money-riesgo").html('<i class="fa fa-money fa-2x" style="color:red;"></i>');
                }else{
                    $("#money-riesgo").html('<i class="fa fa-money" style="color:green;"></i>');
                }
                total_iva_activo=((suma_activo*iva)/100)+suma_activo;
                /*if(presupuesto_activo<suma_activo){
                    $("#money-activo").html('<i class="fa fa-money fa-2x" style="color:red;"></i>');
                }else{
                    $("#money-activo").html('<i class="fa fa-money" style="color:green;"></i>');
                }*/
                total_iva_gasto=((suma_gasto*iva)/100)+suma_gasto;
                /*if(presupuesto_gasto<total_iva_gasto){
                    $("#money-gasto").html('<i class="fa fa-money fa-2x" style="color:red;"></i>');
                }else{
                    $("#money-gasto").html('<i class="fa fa-money" style="color:green;"></i>');
                }*/
                ///***************////
                if((presupuesto_total-total_iva)<0){
                    $("#saldo_total").html('<b style="color:red;">$ '+(presupuesto_total-total_iva).formatPrice()+'</b> COP');
                }else{
                    $("#saldo_total").html('<b style="color:green;">$ '+(presupuesto_total-total_iva).formatPrice()+'</b> COP');
                }
                if((presupuesto_seguridad-total_iva_seguridad)<0){
                    $("#saldo_seguridad").html('<b style="color:red;">$ '+(presupuesto_seguridad-total_iva_seguridad).formatPrice()+'</b> COP');
                }else{
                    $("#saldo_seguridad").html('<b style="color:green;">$ '+(presupuesto_seguridad-total_iva_seguridad).formatPrice()+'</b> COP');
                }
                if((presupuesto_riesgo-total_iva_riesgo)<0){
                    $("#saldo_riesgo").html('<b style="color:red;">$ '+(presupuesto_riesgo-total_iva_riesgo).formatPrice()+'</b> COP');
                }else{
                    $("#saldo_riesgo").html('<b style="color:green;">$ '+(presupuesto_riesgo-total_iva_riesgo).formatPrice()+'</b> COP');
                }
                if((presupuesto_activo-total_iva_activo)<0){
                    $("#saldo_activo").html('<b style="color:red;">$ '+(presupuesto_activo-total_iva_activo).formatPrice()+'</b> COP');
                }else{
                    $("#saldo_activo").html('<b style="color:green;">$ '+(presupuesto_activo-total_iva_activo).formatPrice()+'</b> COP');
                }
                if((presupuesto_gasto-total_iva_gasto)<0){
                    $("#saldo_gasto").html('<b style="color:red;">$ '+(presupuesto_gasto-total_iva_gasto).formatPrice()+'</b> COP');
                }else{
                    $("#saldo_gasto").html('<b style="color:green;">$ '+(presupuesto_gasto-total_iva_gasto).formatPrice()+'</b> COP');
                }
                $("#total_iva").html('$ '+total_iva.formatPrice()+' COP');
                $("#total_iva_seguridad").html('$ '+total_iva_seguridad.formatPrice()+' COP');
                $("#total_iva_riesgo").html('$ '+total_iva_riesgo.formatPrice()+' COP');
                $("#total_iva_activo").html('$ '+total_iva_activo.formatPrice()+' COP');
                $("#total_iva_gasto").html('$ '+total_iva_gasto.formatPrice()+' COP');
                $("#info_procesar").html('');
                $("#procesar").prop("disabled", false);
            }
        });
    }
    function cambiarEstado(estado,producto,tipo,cantidad){
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/cambiar-estado'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                estado: estado,
                producto: producto,
                tipo: tipo,
                cantidad: cantidad
            },
            beforeSend:  function() {
                $('#info').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                if (data.respuesta==true) {
                    consultar(0)
                }
                $("#info").html('');
            }
        });
    }
    var estado_na;
    var producto_na;
    var tipo_na;
    var cantidad_na;
    function setDataNa(estado,producto,tipo,cantidad){
        estado_na=estado;
        producto_na=producto;
        tipo_na=tipo;
        cantidad_na=cantidad;
        $('#cantidad-no-aprobado').find('option').remove().end().append('<option value="0">[Elija Cantidad]</option>')
    .val('0');
        for (var i = 1; i <= cantidad_na; i++) {
            $('#cantidad-no-aprobado').append('<option value="'+i+'">'+i+'</option>');
        }
    }
    function cambiarEstadoNa(){
        if($('#cantidad-no-aprobado').val()!='0'){
            $.ajax({
                url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/cambiar-estado'; ?>",
                type:'POST',
                dataType:"json",
                cache:false,
                data: {
                    estado: estado_na,
                    producto: producto_na,
                    tipo: tipo_na,
                    cantidad: $('#cantidad-no-aprobado').val(),
                    motivo: $("#motivo-no-aprobado").val()
                },
                beforeSend:  function() {
                    $('#info').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                },
                success: function(data){
                    if (data.respuesta==true) {
                        consultar(0)
                    }
                    $('#modal-no-aprobado').modal('toggle');
                    $("#info").html('');
                    estado_na="";
                    producto_na="";
                    tipo_na="";
                    cantidad_na="";
                    $("#motivo-no-aprobado").val("")
                    $('#cantidad-no-aprobado').find('option').remove().end().append('<option value="0">[Elija Cantidad]</option>')
                }
            });
        }else{
            alert('Por favor elija al menos 1 Cantidad')
        }
        
    }
    function subirCotizacion(){
        var val=$('#file').val();
        var pasa_cotizacion=false;
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'gif': case 'jpg': case 'png': case 'jpeg': case 'xlsx': case 'xls': case 'pdf':
                //alert("an image");
                pasa_cotizacion=true;
                break;
            default:
                $('#file').fileinput('clear');
                // error message here
                alert("Por favor, adjunta la cotizacion");
                break;
        }
        if(pasa_cotizacion){
            var data = new FormData();
            data.append('presupuesto',<?php echo $model->id?>);
            var file_input = $('#file');

            data.append('file',file_input[0].files[0]);
            console.log(file_input[0]);
            $.ajax({
                url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/subir-cotizacion'; ?>",
                type:'POST',
                data:data,
                cache:false,
                contentType:false,
                processData:false,
                beforeSend:  function() {
                    $('#info').html('Subiendo... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                },
                success: function(data_response){

                    //if(data_response.respuesta==true){//colocar icono de descarga
                        console.log(data_response.respuesta);
                        $('#modal').modal('hide')
                        $('#info').html('')
                        $('#file').fileinput('clear');
                    //}
                }
            });
        }
    }



    function cambiarGastoActivo(estado,producto,tipo){
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/gasto-activo'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                estado: estado,
                producto: producto,
                tipo: tipo
            },
            beforeSend:  function() {
                $('#info').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                if (data.respuesta==true) {
                    consultar(0)
                }
                $("#info").html('');
            }
        });
    }
    function guardarDatosAdicionales(){
        $("#guardar_datos").prop("disabled", true);
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/guardar-datos'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                proyecto: <?php echo $model->id?>,
                iva: $("#iva").val(),
                orden_interna_gasto: $("#orden_interna_gasto").val(),
                orden_interna_activo: $("#orden_interna_activo").val(),
                metros2:$('#m2').val()
            },
            beforeSend:  function() {
                $('#info_guardar_datos').html('Guardando en Presupuesto... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                if (data.respuesta==true) {
                    iva=$("#iva").val();
                    $("#info_guardar_datos").html('');

                    if (data.orden_interna_gasto!='' && data.orden_interna_activo!='') {
                        orden_interna_gasto=data.orden_interna_gasto;
                        orden_interna_activo=data.orden_interna_activo;
                        $('#cerrar_presupuesto').removeAttr('disabled');
                    }


                }else{
                    $("#info_guardar_datos").html(data.respuesta);
                }
                $("#guardar_datos").prop("disabled", false);
            }
        });
    }
    function cerrarPresupuesto(){
        if(orden_interna_gasto.trim()!='' && orden_interna_activo.trim()!=''){
            var r = confirm("¿Desea seguir para Cerrar el Presupuesto?");
            if (r == true) {
                $("#cerrar_presupuesto").prop("disabled", true);
                $("body").addClass("loading");
                $.ajax({
                    url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/cerrar-presupuesto'; ?>",
                    type:'POST',
                    dataType:"json",
                    cache:false,
                    data: {
                        proyecto: <?php echo $model->id?>
                    },
                    beforeSend:  function() {
                        $('#info_cerrar_presupuesto').html('Cerrando Presupuesto... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                    },
                    success: function(data){
                        $("body").removeClass("loading");
                        $("#info_cerrar_presupuesto").html('');
                        $("#cerrar_presupuesto").prop("disabled", false);
                        $('.lock').prop("disabled", true);
                    }
                });
            }
        }else{
            alert('Debe ingresar las dos ordenes internas.')
            $('#orden_interna_gasto').focus();
        }
    }
    function cambiarEstadoPresupuesto(){
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/estado-presupuesto'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                presupuesto: <?php echo $model->id?>
            },
            beforeSend:  function() {
                $('#info_bloquear_presupuesto').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                if(data.respuesta=='CERRADO'){
                    $("#bloquear_presupuesto").html('<i class="fa fa-lock"></i> DESBLOQUEAR PRESUPUESTO');
                }else if(data.respuesta=='ABIERTO'){
                    $("#bloquear_presupuesto").html('<i class="fa fa-unlock"></i> BLOQUEAR PRESUPUESTO');
                }
                $("#info_bloquear_presupuesto").html('');
            }
        });
    }
    function cambiarGastoActivoCheckBox(estado,tipo){
        var checkboxValues = new Array();
        //recorremos todos los checkbox seleccionados con .each
        $('.checkBoxid').each(function() {
            if($(this).prop('checked')==true){
                checkboxValues.push($(this).attr("id"));
            }
        });
        var productos_id = checkboxValues.toString();
        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/proyectos/gasto-activo-multiple'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                estado: estado,
                productos_id: productos_id,
                tipo: tipo
            },
            beforeSend:  function() {
                $('#info').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                //if (data.respuesta==true) {
                    consultar(0)
                //}
                $("#info").html('');
            }
        });
    }
    Number.prototype.formatPrice = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
    <?php if($model->estado=='ENVIADO'){?>
        $('.lock').prop("disabled", true);
    <?php } ?>
</script>
<style>
.modal-process {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal-process {
    display: block;
}
</style>
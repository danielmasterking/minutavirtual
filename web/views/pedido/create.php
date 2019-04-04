<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

if (isset($especial)) {

    $this->title = 'Formulario de solicitud de pedidos especiales';

} else {

    $this->title = 'Formulario de solicitud de pedidos';
}

?>
<?php if (isset($especial)): ?>

  <?=$this->render('_tabs', ['especial' => $especial])?>

<?php else: ?>

  <?=$this->render('_tabs', ['normal' => $normal])?>

<?php endif;?>

<?php if (isset($done) && $done === '200'): ?>

 <p style="text-align: center;" class="alert alert-success">Pedido creado de forma correcta.</p>

<?php endif;?>

  <?php if (isset($done) && $done === '500'): ?>

 <p style="text-align: center;" class="alert alert-danger">No se pudo guardar el pedido se presentó un problema. Por favor intente mas tarde</p>

<?php endif;?>


<h1 style="text-align: center;"><?=Html::encode($this->title)?></h1>
<div id="info"></div>
<?php if (!isset($especial)): ?>


<?=$this->render('_form', [
  'model'            => $model,
  'dependencias'     => $dependencias,
  'marcasUsuario'    => $marcasUsuario,
  'distritosUsuario' => $distritosUsuario,
  'zonasUsuario'     => $zonasUsuario,
  'usuario'          => $usuario,
])?>
<script>
  var url="<?php echo Yii::$app->request->baseUrl . '/detalle-maestra/productos'; ?>";
  var nombre_boton='btn-add-producto';
  var codigo_dependencia;
</script>

<?php else: ?>

<?=$this->render('_formEspeciales', [
  'model'            => $model,
  'dependencias'     => $dependencias,
  'marcasUsuario'    => $marcasUsuario,
  'distritosUsuario' => $distritosUsuario,
  'zonasUsuario'     => $zonasUsuario,
  'usuario'          => $usuario,
])?>

<script>
  var url="<?php echo Yii::$app->request->baseUrl . '/maestra-especial/productos'; ?>";
  var nombre_boton='btn-add-producto-especial';
  
</script>
<?php endif;?>
<?php
$data_productos = array();
?>
<script>
 // var productos = <?php echo json_encode($data_productos); ?>;
  var productos = [];
  var len_productos = productos.length;
  var index_productos = 1;
  //console.log(len_productos);
  var registros=0;
  var paginas=0;
  var contador=1;
function buscarPedidos(page,codigo_dependencia){
	console.log('codigo_dependencia: '+codigo_dependencia);
  $.ajax({
      url:url,
      type:'POST',
      dataType:"json",
      cache:false,
      data: {
          page: page,
		      codigo_dependencia: codigo_dependencia
      },
      beforeSend:  function() {
        $('#info').html('Cargando Productos... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
      },
      success: function(data){
        
		registros=data.count;
        
		if(contador==2){
          paginas=Math.ceil((registros/500));
        }
		
        var obj = JSON.parse(data.resultado);
        for ( var index=0; index<obj.length; index++ ) {
            //console.log(obj[index]['nombre'])
            productos.push( obj[index] );
        }
		
        if (contador <= paginas){
       
    	  buscarPedidos(contador,codigo_dependencia);
          contador++;
        
		}else{
        
     		$("#"+nombre_boton).prop('disabled', false);
            $('#info').html('');
        }
      }
  });
}
$("#"+nombre_boton).prop('disabled', true);


<?php if (!isset($especial)){ ?>
//ejecutar cuando se seleccione sucursal
//activar elemento onchange
if($("#pedido-centro_costo_codigo").length > 0){
   $("#pedido-centro_costo_codigo").on('change',function(){
      
      codigo_dependencia = $("#pedido-centro_costo_codigo").val();
      $("#pedido-centro_costo_codigo").prop('disabled',true);
      buscarPedidos( contador, codigo_dependencia );
      contador++;
     
   });
}
$(".enviar_form").on('click',function(){
  $('#pedido-centro_costo_codigo').select2("enable",true);
});
<?php }else{ ?>
  buscarPedidos( contador, "" );
  contador++;
<?php } ?>
function validarPedido(){
  var val=$('#pedido-file').val();
  var pasa_cotizacion=false;
  var validar_cotizacion=false;
  $("select[name*=sel-produ]").each(function(){
    var cod_material=$('option:selected', this).attr('cod_material');
      if(cod_material=='1034280' || cod_material=='1034279' || cod_material=='1034281'){
        validar_cotizacion=true;//console.info($('option:selected', this).attr('cod_material'))
      }
  });
  if(validar_cotizacion){
      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'gif': case 'jpg': case 'png': case 'jpeg': case 'xlsx': case 'xls': case 'pdf':
            //alert("an image");
            pasa_cotizacion=true;
            break;
        default:
            $('#pedido-file').val('');
            // error message here
            alert("Por favor, adjunta la cotizacion");
            break;
      }
      if(pasa_cotizacion){
        if(validarProductos()){
          if($('#pedido-observaciones').val().trim().length > 0){
            document.getElementById("pedido-form").submit();
          }else{
            alert("Por favor, ingrese la observacion");
            $('#pedido-observaciones').focus();
          }
        }
      }
  }else{
    if(validarCantidadCreate()){
      if($('#pedido-observaciones').val().trim().length > 0){
        document.getElementById("pedido-form").submit();
      }else{
        alert("Por favor, ingrese la observacion");
        $('#pedido-observaciones').focus();
      }
    }
  }
}
function validarProductos(){
  var pasa_precio=true;
  var pasa_cantidad=true;
  var pasa_descripcion=true;
  var pasa_proveedor=true;
  $("input[name*=txt-precio]").each(function(){
    //console.log($(this).is('[readonly]'))
    if(!$(this).is('[readonly]')){
      var precio=$(this).val();
      if(precio <= 0 || precio == null || precio == 'undefined'){
        pasa_precio=false;
        $(this).tooltip({'trigger':'focus', 'title': 'Precio debe ser mayor a 0'});
        //alert('Precio debe ser mayor a 0');
        $(this).focus();
        $(this).maskMoney('destroy');
        return false;
      }
    }
  });
  if(pasa_precio){
    $("input[name*=txt-cant]").each(function(){
      var cantidad=$(this).val();
      if(cantidad <= 0 || cantidad == null || cantidad == 'undefined' || !isNumber(cantidad)){
        pasa_cantidad=false;
        $(this).tooltip({'trigger':'focus', 'title': 'Cantidad debe ser mayor a 0'});
        //alert('Cantidad debe ser mayor a 0');
        $(this).focus();
        $(this).select();
        return false;
      }
    });
    if(pasa_cantidad){
      $("input[name*=txt-prod]").each(function(){
        if(!$(this).is('[readonly]')){
          var desc=$(this).val();
          if(desc==''){
            pasa_descripcion=false;
            $(this).tooltip({'trigger':'focus', 'title': 'La descripcion debe Llenar'});
            $(this).focus();
            //alert('La descripcion debe Llenar');
            return false;
          }
        }
      });
      if(pasa_descripcion){
        $("input[name*=txt-proveedor]").each(function(){
          if(!$(this).is('[readonly]')){
            var prov=$(this).val();
            if(prov==''){
              pasa_proveedor=false;
              $(this).tooltip({'trigger':'focus', 'title': 'El proveedor no debe estar Vacio'});
              //alert('El proveedor no debe estar Vacio');
              $(this).focus();
              return false;
            }
          }
        });
      }
    }
  }
  
  
  return pasa_precio && pasa_cantidad && pasa_descripcion && pasa_proveedor;
}
function validarCantidadCreate(){
  var pasa_cantidad=true;
    $("input[name*=txt-cant]").each(function(){
      var cantidad=$(this).val();
      if(cantidad <= 0 || cantidad == null || cantidad == 'undefined' || !isNumber(cantidad)){
        pasa_cantidad=false;
        $(this).tooltip({'trigger':'focus', 'title': 'Cantidad debe ser mayor a 0'});
        //alert('Cantidad debe ser mayor a 0');
        $(this).focus();
        $(this).select();
        return false;
      }
    });
  return pasa_cantidad;
}
function enviar(){
  if(validarCantidadCreate()){
      var form=document.getElementById("w0");
      var input = document.createElement('input');
      input.type = 'hidden';
      input.id = 'centro_costo_codigo';
      input.name = 'Pedido[centro_costo_codigo]';
      input.value = ''+$('#pedido-centro_costo_codigo').val();
      form.appendChild(input);
      form.submit();
  }
}

$(document).on("keypress", "input[name*=txt-cant]", function(){
    $(this).tooltip('destroy');
});
$(document).on("keypress", "input[name*=txt-prod]", function(){
    $(this).tooltip('destroy');
});
$(document).on("keypress", "input[name*=txt-proveedor]", function(){
    $(this).tooltip('destroy');
});
$(document).on("keypress", "input[name*=txt-precio]", function(){
    if(!$(this).is('[readonly]')){
      $(this).tooltip('destroy');
      $(this).maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
    }
});
$(document).on("keyup", "input[name*=txt-precio]", function(){
  this.value = this.value.replace(/[^0-9\.]/g,'');
});
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
</script>

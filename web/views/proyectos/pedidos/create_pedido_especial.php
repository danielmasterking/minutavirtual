<?php

use yii\helpers\Html;
$this->title = 'Solicitud de Pedidos Especiales';
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li class="active">Crear Pedido Especial</li>
</ol>
<h2 style="text-align: center;"><?=Html::encode($this->title)?></h2>

<div id="info"></div>

<?=$this->render('_form_pedido_especial')?>
<script>
  var url="<?php echo Yii::$app->request->baseUrl.'/maestra-especial/productos'; ?>";
  var nombre_boton='btn-add-producto-especial';
  var codigo_dependencia;
</script>

<?php
$data_productos = array();
?>
<script>
  var productos = [];
  var len_productos = productos.length;
  var index_productos = 1;
  var registros=0;
  var paginas=0;
  var contador=1;
  function buscarPedidos(page,codigo_dependencia){
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
  function validarPedido(){
    var flag=true;
    if($('#tipo_presupuesto').val()=='0'){
      flag=false;
    }
    if(flag){
      var val=$('#file').val();
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
                $('#file').val('');
                // error message here
                alert("Por favor, adjunta la cotizacion");
                break;
          }
          if(pasa_cotizacion){
            if(validarProductos()){
              if($('#observaciones').val().trim().length > 0){
                enviarFormulario();
              }else{
                alert("Por favor, ingrese la observacion");
                $('#observaciones').focus();
              }
            }
          }
      }else{
        if(validarCantidadCreate()){
          if($('#observaciones').val().trim().length > 0){
            enviarFormulario();
          }else{
            alert("Por favor, ingrese la observacion");
            $('#observaciones').focus();
          }
        }
      }
    }else{
      alert('Elija el presupuesto');
      $('#tipo_presupuesto').focus();
      $("#tipo_presupuesto").css("border","1px solid red");
    }
  }
  function enviarFormulario(){
    var form=document.getElementById("pedido-form");
    var input = document.createElement('input');
    input.type = 'hidden';
    input.id = 'pedido';
    input.name = 'pedido';
    input.value = '<?=$id?>';
    form.appendChild(input);
    form.submit();
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
  $("#tipo_presupuesto").change( function() {
    if($(this).val()=='0'){
    }else{
      $("#tipo_presupuesto").css("border","");
    }
  });
  function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
  $("#"+nombre_boton).prop('disabled', true);
  buscarPedidos( contador, <?= $ceco ?> );
  contador++;
</script>

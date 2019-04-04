<?php

use yii\helpers\Html;
$this->title = 'Solicitud de Pedidos';
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li class="active">Crear Pedido Normal</li>
</ol>
<h2 style="text-align: center;"><?=Html::encode($this->title)?></h2>

<div id="info"></div>

<?=$this->render('_form_pedido')?>
<script>
  var url="<?php echo Yii::$app->request->baseUrl . '/detalle-maestra/productos'; ?>";
  var nombre_boton='btn-add-producto';
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
  function enviar(){
    var flag=true;
    if($('#tipo_presupuesto').val()=='0'){
      flag=false;
    }
    if(flag){
      if(validarCantidadCreate()){
        var form=document.getElementById("form_create");
        var input = document.createElement('input');
        input.type = 'hidden';
        input.id = 'pedido';
        input.name = 'pedido';
        input.value = '<?=$id?>';
        form.appendChild(input);
        form.submit();
      }
    }else{
      alert('Elija el presupuesto');
      $('#tipo_presupuesto').focus();
      $("#tipo_presupuesto").css("border","1px solid red");
    }
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

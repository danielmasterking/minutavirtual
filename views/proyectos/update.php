<?php

use yii\helpers\Html;
use kartik\money\MaskMoney;
use yii\helpers\Url;
MaskMoney::widget([
    'name' => 'amount_drcr',
    'value' => 20322.22
]);

$this->title = 'Agregar al Presupuesto de: ' . $model->nombre;
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li class="active">Agregar Presupuesto</li>
</ol>
<a href="<?php echo Url::toRoute('proyectos/index')?>" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i>
</a>
<h2 style="text-align: center;"><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form_update', [
    'model' => $model,
]) ?>
<script>
$(function(){
    $("#presupuesto_seguridad").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
    $("#presupuesto_riesgo").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
    $("#presupuesto_activo").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
    $("#presupuesto_gasto").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});

});
// $(document).on("keyup", "#presupuesto_seguridad, #presupuesto_riesgo", function(){
//     var seguridad=parseInt(($('#presupuesto_seguridad').val()).replaceAll(".",""))
//     var riesgo=parseInt(($('#presupuesto_riesgo').val()).replaceAll(".",""))
//     $("#info_suma").html('$ '+(seguridad+riesgo).formatPrice()+' COP')
// });


$(document).on("keyup", "#presupuesto_activo, #presupuesto_gasto", function(){
    var seguridad=parseInt(($('#presupuesto_activo').val()).replaceAll(".",""))
    var riesgo=parseInt(($('#presupuesto_gasto').val()).replaceAll(".",""))
    $("#info_suma").html('$ '+(seguridad+riesgo).formatPrice()+' COP')
});



function validar(){
    var flag=true;
    // var presupuesto_seguridad=parseInt(($("#presupuesto_seguridad").val()).replaceAll(".", ""));
    // var presupuesto_riesgo=parseInt(($("#presupuesto_riesgo").val()).replaceAll(".", ""));

    var presupuesto_activo=parseInt(($("#presupuesto_activo").val()).replaceAll(".", ""));
    var presupuesto_gasto=parseInt(($("#presupuesto_gasto").val()).replaceAll(".", ""));
    /*var presupuesto_activo=parseInt(($("#presupuesto_activo").val()).replaceAll(".", ""));
    var presupuesto_gasto=parseInt(($("#presupuesto_gasto").val()).replaceAll(".", ""))*/
    if(isNaN(presupuesto_activo)){
    	$("#presupuesto_activo").val("0")
    }else{
    	$("#presupuesto_activo").val(presupuesto_activo)
    }
    if(isNaN(presupuesto_gasto)){
    	$("#presupuesto_gasto").val("0")
    }else{
    	$("#presupuesto_gasto").val(presupuesto_gasto)
    }
    /*if(isNaN(presupuesto_activo)){
    	$("#presupuesto_activo").val("0")
    }else{
    	$("#presupuesto_activo").val(presupuesto_activo)
    }
    if(isNaN(presupuesto_gasto)){
        $("#presupuesto_gasto").val("0")
    }else{
        $("#presupuesto_gasto").val(presupuesto_gasto)
    }*/
    presupuesto_activo=parseInt(($("#presupuesto_activo").val()).replaceAll(".", ""));
    presupuesto_gasto=parseInt(($("#presupuesto_gasto").val()).replaceAll(".", ""));
    /*presupuesto_activo=parseInt(($("#presupuesto_activo").val()).replaceAll(".", ""));
    presupuesto_gasto=parseInt(($("#presupuesto_gasto").val()).replaceAll(".", ""));*/
    if(presupuesto_activo<1 && presupuesto_gasto<1){
    	alert('Debe agregar una cantidad a alguno de los presupuestos.')
    	flag=false;
    }
    
    if(flag){
        var form=document.getElementById("form_update");
        form.submit();
    }
}
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};
Number.prototype.formatPrice = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
};
$('#presupuesto_seguridad').val(0)
$('#presupuesto_riesgo').val(0)
</script>
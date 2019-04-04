<?php

use yii\helpers\Html;
use kartik\money\MaskMoney;
MaskMoney::widget([
    'name' => 'amount_drcr',
    'value' => 20322.22
]);

$this->title = 'Crear Proyecto';
?>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'dependencias'     => $dependencias,
    'marcasUsuario'    => $marcasUsuario,
    'distritosUsuario' => $distritosUsuario,
    'zonasUsuario'     => $zonasUsuario,
]) ?>
<script>
$(function(){
	$("#presupuesto_total").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
    $("#presupuesto_seguridad").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
    $("#presupuesto_riesgo").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
    $("#presupuesto_heas").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
});
function validar(){
    var flag=false;
    var presupuesto_total=parseInt(($("#presupuesto_total").val()).replace(".", ""));
    var presupuesto_seguridad=parseInt(($("#presupuesto_seguridad").val()).replace(".", ""));
    var presupuesto_riesgo=parseInt(($("#presupuesto_riesgo").val()).replace(".", ""));
    var presupuesto_heas=parseInt(($("#presupuesto_heas").val()).replace(".", ""));
    if(isNaN(presupuesto_total)){
        $("#presupuesto_total").val("0")
    }else{
        $("#presupuesto_total").val(presupuesto_total)
    }
    if(isNaN(presupuesto_seguridad)){
        $("#presupuesto_seguridad").val("0")
    }else{
        $("#presupuesto_seguridad").val(presupuesto_seguridad)
    }
    if(isNaN(presupuesto_riesgo)){
        $("#presupuesto_riesgo").val("0")
    }else{
        $("#presupuesto_riesgo").val(presupuesto_riesgo)
    }
    if(isNaN(presupuesto_heas)){
        $("#presupuesto_heas").val("0")
    }else{
        $("#presupuesto_heas").val(presupuesto_heas)
    }
    if(presupuesto_seguridad<1 && presupuesto_riesgo<1 && presupuesto_heas<1){
        alert('Debe agregar una cantidad a alguno de los presupuestos.')
    }else{
        var suma=presupuesto_seguridad+presupuesto_riesgo+presupuesto_heas;
        if(presupuesto_total===suma){
            flag=true;
        }else{
            alert('La suma de los presupuestos no concuerda con el presupuesto Total. Por favor verifique los presupuestos.')
        }
    }
    if(flag){
        var form=document.getElementById("form_create");
        form.submit();
    }
} 
</script>
<?php

use yii\helpers\Html;
use kartik\money\MaskMoney;
MaskMoney::widget([
    'name' => 'amount_drcr',
    'value' => 20322.22
]);

$this->title = 'Agregar al Presupuesto de: ' . $model->nombre;
?>
<h2 style="text-align: center;"><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form_update', [
    'model' => $model,
]) ?>
<script>
$(function(){
    $("#presupuesto_seguridad").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
    $("#presupuesto_riesgo").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
    $("#presupuesto_heas").maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:true, allowNegative:false, suffix: ''});
});
function validar(){
    var flag=true;
    var presupuesto_seguridad=parseInt(($("#presupuesto_seguridad").val()).replace(".", ""));
    var presupuesto_riesgo=parseInt(($("#presupuesto_riesgo").val()).replace(".", ""));
    var presupuesto_heas=parseInt(($("#presupuesto_heas").val()).replace(".", ""));
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
    	flag=false;
    }
    
    if(flag){
        var form=document.getElementById("form_update");
        form.submit();
    }
} 
</script>
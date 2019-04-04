<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Equivalencias';	

?>
   <?php if(isset($done) && $done === '200'):?>
   
     <p style="text-align: center;" class="alert alert-success">Equivalencia agregada.</p>
   
   <?php endif;?>
   
   
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	
        'model' => $model,
        'equivalencias' => $equivalencias,
		'productos_especiales' => $productos_especiales,
		'productos' => $productos,
    ]) ?>
<script>
  function eliminar_todo(){
    var txt;
    var r = confirm("¿Realmente desea borrar todas las Equivalencias?");
    if (r == true) {
        location.href='<?php echo Url::toRoute('equivalencia/delete-all')?>';
    }
  }
</script>
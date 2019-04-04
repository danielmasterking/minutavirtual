<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */


$this->title = 'Dispositivo Fijo';	

?>
      <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>

	<div class="form-group">

	<?= Html::a('Prefacturas Seguridad',Yii::$app->request->baseUrl.'/centro-costo/prefacturas?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	<?= Html::a('Dispositivo Electrónico',Yii::$app->request->baseUrl.'/centro-costo/electronico?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
		
	</div>	  
	  
   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formModelo', [
        'monitoreos' => $monitoreos,
		'model' => $model,
		'codigo_dependencia' => $codigo_dependencia,

    ]) ?>
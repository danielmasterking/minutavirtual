<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Actualizar Capacitación '.$model->id;
?>
		<div class="form-group">
        <?php if(isset($dependencia)):?>
		  <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/capacitacion?id='.$dependencia,['class'=>'btn btn-primary']) ?>
		<?php else:?>
		 <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/usuario/capacitacion?id='.$model->usuario,['class'=>'btn btn-primary']) ?>
		<?php endif;?>
		


		</div> 

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'dependencias' => $dependencias,
		'novedades' => $novedades,
		'cordinadores' => $cordinadores,
		'marcasUsuario' => $marcasUsuario,
		'distritosUsuario' => $distritosUsuario,
		'zonasUsuario' => $zonasUsuario,
		
    ]) ?>
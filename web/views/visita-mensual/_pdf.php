<?php


/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



/*Server bluehost*/
$logo = '/home/cvsccomc/public_html/sgs/web/img/EXITOPORTADA.png';
$prefijo = '/home/cvsccomc/public_html/sgs/web';

/*Servidor Local*/
//$logo = '/exito/web/img/EXITOPORTADA.png';
//$prefijo = '/exito/web';

/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Formulario de visita Semestral';
?>
<div class="container" style="margin-top:5px;padding-top:5px;">
	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo $logo; ?>">
			<h1 style="text-align: center;"><?= $this->title ?></h1>
			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Fecha Visita: </strong><?=$model->fecha_visita?></label>
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Dependencia: </strong><?=$model->dependencia->nombre?></label>
				</div>
			</div>	   

			<div class="col-md-12">
				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Atendió: </strong><?=$model->atendio?></label>
				</div>

				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Otro: </strong><?=$model->otro?></label>
				</div>	   
			</div>

			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Observaciones:</strong></label>
					<p><?=$model->detalle?></p>
				</div>	
			</div>

			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Recomendaciones:</strong></label>
					<p><?=$model->recomendaciones?></p>
				</div>
			</div>
		</div>

		<pagebreak/>
			<h4 style="text-align: center;"><strong>Registro Fotografico</strong></h4>
	     	<?php
		    /**********************Rendering Image *******************************/
		    foreach ($model_foto as $key) {?>
		    	<img src="<?php echo $prefijo.$key->archivo; ?>">
		    <?php } ?>

	</div>

</div>
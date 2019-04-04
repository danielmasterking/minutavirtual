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

$this->title = 'Formulario de visita por solicitud o activación';
?>


<div class="container" style="margin-top:5px;padding-top:5px;">

	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo $logo; ?>">
			<h1 style="text-align: center;"><?= $this->title ?></h1>
			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Fecha: </strong><?=$model->fecha?></label>
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Tipo Solicitud: </strong><?=$model->novedad->nombre?></label>

				</div>
			</div>	   

			<div class="col-md-12">
				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Dependencia: </strong><?=$model->dependencia->nombre?></label>
				</div>

				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Cantidad de apoyo: </strong><?=$model->cantidad_apoyo?></label>
				</div>	   
			</div>

			<div class="col-md-12">
				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Otros: </strong><?=$model->otros?></label>
				</div>

				<div class="col-md-6">
					<p>&nbsp;</p>
					<label><strong>Cantidad de apoyo: </strong><?=$model->cantidad_apoyo_otros?></label>

				</div>	   
			</div>

			<div class="col-md-12">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<label><strong>Observaciones:</strong></label>
					<p><?=$model->descripcion?></p>
				</div>	
			</div>

			<pagebreak/>
				<h4 style="text-align: center;"><strong>Registro Fotografico</strong></h4>
		     	<?php
			    /**********************Rendering Image *******************************/
			    foreach ($model_foto as $key) {?>
			    	<img src="<?php echo $prefijo.$key->imagen; ?>">
			    <?php } ?>
		</div>
	</div>
</div>
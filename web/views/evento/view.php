<?php
use yii\helpers\Html;
use marqu3s\summernote\Summernote;

$this->title = 'Detalle de Visita por Solicitud o Activación ';

?>
			<div class="visita-dia-form">

				<div class="form-group">
					<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/centro-costo/evento?id='.$model->centro_costo_codigo,['class'=>'btn btn-primary']) ?>

					<?= Html::a('<i class="fa fa-file-pdf-o"></i> Pdf',Yii::$app->request->baseUrl.'/evento/pdf?id='.$model->id,['class'=>'btn btn-primary pull-right']) ?>

				</div>

				<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
				<div class="col-md-12">
					<div class="col-md-12">
						<label>Fecha</label>
						<input type="text" class="form-control" value="<?=$model->fecha?>" readonly="readonly" />


					</div>
				</div>
				<p></p>

				<div class="col-md-12">
					<div class="col-md-12">
						<label>Tipo de solicitud</label>
						<input type="text" class="form-control" value="<?=$model->novedad->nombre?>" readonly="readonly" />


						<div class="col-md-6">
							<label>Dependencia</label>
							<input type="text" class="form-control" value="<?=$model->dependencia->nombre?>" readonly="readonly" />

						</div>

						<div class="col-md-3">

							<label>Cantidad de apoyo</label>
							<input class="form-control" type="text" value="<?=$model->cantidad_apoyo?>" readonly="readonly" />


						</div>

						<div class="col-md-3">




						</div>



					</div>
				</div>

				<div class="col-md-12">

					<div class="col-md-12">

						<div class="col-md-6">
							<label>Otros</label>
							<input class="form-control" type="text" value="<?=$model->otros?>" readonly="readonly" />

						</div>

						<div class="col-md-3">
							<label>Cantidad de apoyo</label>
							<input class="form-control" type="text" value="<?=$model->cantidad_apoyo_otros?>" readonly="readonly" />

						</div>

						<div class="col-md-3">




						</div>


					</div>



				</div>

	   <!--<div class="col-md-12">
	   
	     <div class="col-md-12">
		   
		   <div class="form-group"> 
		   
		   <label><strong>Detalle del evento:</strong></label>
		   
		   </div>
		  
		   
		   <div class="col-md-6">
		      
			  <label><input type="checkbox" id="marca-chk" checked="checked"/> Marca</label>
			  
			  <div id="div-marca" class="show">
			  
			  			 
              <label>Marca</label>
			  
			  </div>

			 
		   
		   </div>
		   <div class="col-md-6">
		       <label><input type="checkbox" id="distrito-chk" checked="checked"/> Distrito</label>
			  
			  <div id="div-distrito" class="show">
               
			   <label>Distrito</label>
			 
			 </div>
		   </div>
		   
	     </div>   
		
	 </div>-->

	 <p>&nbsp;</p>

	 <div class="col-md-12">
	 	<div class="col-md-12">

	 		<label>Observación</label>
	 		<?= Summernote::widget([

	 			'name' => 'descripcion',
	 			'value' => $model->descripcion,
	 			'clientOptions' => [

	 			'enable' => false,

	 			]
	 			]) ?>

	 		</div>
	 	</div>	

	 	<p>&nbsp;</p>
	 	<div class="col-md-12">
	 		<label>Archivo</label>
	 		<?php foreach ($model_foto as $key) {?>
	 			<p>
	 				<a href="http://cvsc.com.co/sgs/web<?=$key->imagen?>" download>
	 					<?=$key->imagen?>
	 				</a>
	 			</p>
	 		<?php } ?>
	 	</div>
	 </div>
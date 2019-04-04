<?php 
use yii\helpers\Html;

$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
	$permisos = Yii::$app->session['permisos-exito'];
}
$this->title = 'Dependencias';


?>



<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">
    <?php //if(in_array("dependencia-create", $permisos)):?>
	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/centro-costo/create',['class'=>'btn btn-primary']) ?>
	<?php //endif;?>	
	</div>	



<table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	<thead>
		<tr>
			<th></th>
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Ciudad</th>
			<th>Estado</th>
			<th>Empresa</th>
		</tr>

	</thead>
	<tbody>
		
		<?php foreach($dependencias as $dependencia): ?>
		<tr>
			<td>
				<?php
						   
				   echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$dependencia->codigo,['title'=>'ver']);
				   echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/update?id='.$dependencia->codigo);
				   if(in_array("administrador", $permisos)){
					
					echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/delete?id='.$dependencia->codigo,['data-method'=>'post']);  
				   }
						   
							

			    ?>
			</td>
			<td><?= $dependencia->codigo?></td>
			<td><?= $dependencia->nombre?></td>
			<td><?= $dependencia->ciudad->nombre?></td>
			<td><?= $dependencia->estado?></td>
			<td><?= $dependencia->emp->nombre?></td>


		</tr>
		<?php endforeach;?>



	</tbody>


</table>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenido de Maestra';

?>
<?= $this->render('_tabs',['maestra' => $maestra]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/index',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           
		   <th>Material</th>
           <th>Texto Breve</th>
		   <th>Documento de Compras</th>
		   <th>Posición</th>
		   <th>Distribución</th>
		   <th>Marca</th>
		   <th>Estado</th>
		   <th></th>
		   <th></th>
		   
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($productos as $producto):?>	  
			   
              <tr>			   

                
				<td><?= $producto->material?></td>
				<td><?= $producto->texto_breve?></td>
				<td><?= $producto->documento_compras?></td>
				<td><?= $producto->posicion?></td>
				<td><?= $producto->distribucion?></td>
				<td><?= $producto->marca?></td>
				<td><?= $producto->estado?></td>
				<!-- Llamado ajax para aprobar-->
				<td>
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['maestra-proveedor/activar-producto?id_detalle_producto='.$producto->id.'&id_maestra='.$producto->maestra_proveedor_id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>
				<td>
				<?php Pjax::begin(); ?>
				<?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', ['maestra-proveedor/desactivar-producto?id_detalle_producto='.$producto->id.'&id_maestra='.$producto->maestra_proveedor_id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				</td>
     			
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
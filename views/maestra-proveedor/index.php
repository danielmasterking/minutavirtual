<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maestra Proveedor';

?>
<?= $this->render('_tabs',['maestra' => $maestra]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th></th>
		   <th>Proveedor</th>
           <th>Marca</th>
		   <th>Regional</th>
		   <th>Estado</th>
		   <th></th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($maestras as $novedad):?>	


				<?php
				
				//regionales
				$ubicacion = '';
				
				$r1 = $novedad->zona != null ? $novedad->zona->nombre : '';
				$r2 = $novedad->zona2 != null ? $novedad->zona2->nombre : '';
				$r3 = $novedad->zona3 != null ? $novedad->zona3->nombre : '';
				$r4 = $novedad->zona4 != null ? $novedad->zona4->nombre : '';
				$r5 = $novedad->zona5 != null ? $novedad->zona5->nombre : '';
				
				$ubicacion = $r1.'-'.$r2.'-'.$r3.'-'.$r4.'-'.$r5;

				?>			 
			   
              <tr>

			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/update?id='.$novedad->id);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/delete?id='.$novedad->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento?']);

                    ?>
				</td>
				<td>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('Desactivar', ['maestra-proveedor/desactivar-maestra?id='.$novedad->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>			  
				</td>				
                
				<td><?= $novedad->proveedor->nombre?></td>
     			<td><?= $novedad->marca->nombre?></td>
				<td><?= $ubicacion?></td>
				<td><?= $novedad->estado?></td>
				<td><?= Html::a('Detalle',Yii::$app->request->baseUrl.'/maestra-proveedor/view?id='.$novedad->id,['class'=>'btn btn-primary']) ?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
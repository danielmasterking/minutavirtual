<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
		   <th>Proveedor</th>
           <th>Marca</th>
		   <th>Regional</th>
		   <th></th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($maestras as $novedad):?>	  
			   
              <tr>			   
			   <td><?php
               // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/update?id='.$novedad->id);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/maestra-proveedor/delete?id='.$novedad->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento?']);

                    ?>
				</td>
                
				<td><?= $novedad->proveedor->nombre?></td>
     			<td><?= $novedad->marca->nombre?></td>
				<td><?= $novedad->zona->nombre?></td>
				<td><?= Html::a('Detalle',Yii::$app->request->baseUrl.'/maestra-proveedor/view?id='.$novedad->id,['class'=>'btn btn-primary']) ?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
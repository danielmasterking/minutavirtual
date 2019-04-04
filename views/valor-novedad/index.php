<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Valores Novedades';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/valor-novedad/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
           <th>Novedad</th>
		   <th>Valor</th>
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($novedades as $novedad):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/valor-novedad/update?id='.$novedad->id);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/valor-novedad/delete?id='.$novedad->id,['data-method'=>'post']);

                    ?>
				</td>
                
     			<td><?= $novedad->novedadCategoriaVisita->nombre?></td>
				<td><?= $novedad->resultado->nombre?></td>
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Areas Dependencia';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/area-dependencia/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
           <th>Nombre</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($areas as $area):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/area-dependencia/update?id='.$area->id);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/area-dependencia/delete?id='.$area->id,['data-method'=>'post']);

                    ?>
				</td>
                
     			<td><?= $area->nombre?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
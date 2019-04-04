<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regionales';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/zona/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
           <th>Nombre</th>
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($zonas as $zona):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/zona/update?id='.$zona->id);
                echo Html::a('<i class="fa fa-plus fa-fw"></i>',Yii::$app->request->baseUrl.'/zona/ciudades?id='.$zona->id,['title' => 'Agregar Ciudades']);
				echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/zona/delete?id='.$zona->id,['data-method'=>'post']);

                    ?>
				</td>
                
     			<td><?= $zona->nombre?></td>
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
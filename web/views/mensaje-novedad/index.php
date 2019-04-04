<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes Valor Novedades';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/mensaje-novedad/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
           <th>Mensaje</th>
		   <th>Novedad</th>
		   <th>Resultado</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($mensajes as $mensaje):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/mensaje-novedad/update?id='.$mensaje->id);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/mensaje-novedad/delete?id='.$mensaje->id,['data-method'=>'post']);

                    ?>
				</td>
                
     			<td><?= $mensaje->mensaje?></td>
				<td><?= $mensaje->valorNovedad->novedadCategoriaVisita->nombre?></td>
				<td><?= $mensaje->valorNovedad->resultado->nombre?></td>
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
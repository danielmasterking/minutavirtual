<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maestra Especial';

?>
<?= $this->render('_tabs',['maestraEspecial' => $maestraEspecial]) ?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/maestra-especial/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Material</th>
           <th>Texto Breve</th>
		   <th>Precio Sugerido</th>
		   <th>Imputación</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($maestras as $maestra):?>	  
			   
              <tr>			   
			   <td><?php
             
     			 echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/maestra-especial/update?id='.$maestra->id);
                 echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/maestra-especial/delete?id='.$maestra->id,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento?']);

                    ?>
				</td>
                
				<td><?= $maestra->material?></td>
     			<td><?= $maestra->texto_breve?></td>
				<td><?= $maestra->precio?></td>
				<td><?= $maestra->imputacion?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
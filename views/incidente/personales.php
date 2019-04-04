<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Siniestros';


?>
    <?= $this->render('_tabs',['personales' => $personales]) ?>

        
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Codigo</th>
           <th>Fecha</th>
		   <th>Tipo</th>
		   <th>Observaciones</th>
          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($siniestros as $siniestro):?>	  
			   
              <tr>			   
			   <td><?php
			   echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/siniestro/view-personales?id='.$siniestro->id,['title'=>'ver']);
              // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
               //echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/capacitacion/delete?id='.$capacitacion->capacitacion_id,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $siniestro->id?></td>
     			<td><?= $siniestro->fecha?></td>
				<td><?= $siniestro->novedad->nombre?></td>
				<td><?= $siniestro->observacion?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
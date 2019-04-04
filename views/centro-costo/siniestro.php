<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Siniestros';

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


?>
    <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'siniestro' => $siniestro]) ?>

        
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Codigo</th>
           <th>Fecha Creación</th>
		   <th>Fecha Siniestro</th>
		   <th>Novedad</th>
		   <th>Observaciones</th>
          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($siniestros as $siniestro):?>	  
			   
              <tr>			   
			   <td><?php
			   echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/siniestro/view?id='.$siniestro->id.'&dependencia='.$codigo_dependencia,['title'=>'ver']);
               
			   if(in_array("administrador", $permisos) || Yii::$app->session['usuario-exito'] == $siniestro->usuario){
					
				  echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/siniestro/update?id='.$siniestro->id);	
					
				}
			   
			   if(in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/siniestro/delete?id='.$siniestro->id.'&dependencia='.$codigo_dependencia,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar este elemento']);
  
			   }
			   
			   //echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/siniestro/update?id='.$siniestro->id);
               //echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/siniestro/delete?id='.$siniestro->id,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $siniestro->id?></td>
     			<td><?= $siniestro->fecha?></td>
				<td><?= $siniestro->fecha_siniestro?></td>
				<td><?= $siniestro->novedad->nombre?></td>
				<td><?= $siniestro->observacion?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
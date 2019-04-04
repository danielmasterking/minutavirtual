<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Capacitaciones';
$permisos = array();

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
    <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'capacitacion' => $capacitacion]) ?>

        
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Codigo</th>
           <th>Fecha capacitación</th>
		   <th>Tema</th>
		   <th>Observaciones</th>
          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($capacitaciones as $capacitacion):?>	  
			   
              <tr>			   
			   <td><?php
			   echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/capacitacion/view?id='.$capacitacion->capacitacion_id.'&dependencia='.$codigo_dependencia,['title'=>'ver']);
               if(in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/capacitacion/delete?id='.$capacitacion->capacitacion_id.'&dependencia='.$codigo_dependencia,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar este elemento']);
  
			   }
			  
                    ?>
				</td>
                <td><?= $capacitacion->capacitacion_id?></td>
     			<td><?= $capacitacion->capacitacion->fecha_capacitacion?></td>
				<td><?= $capacitacion->capacitacion->novedad->nombre?></td>
				<td><?= $capacitacion->capacitacion->observaciones?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas períodicas';
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


?>
    <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'modelo_prefactura' => $modelo_prefactura]) ?>
	
	<div class="form-group">

	<?= Html::a('Dispositivo Fijo',Yii::$app->request->baseUrl.'/centro-costo/modelo?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
		
	</div>	
        
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Año</th>
           <th>Mes</th>

          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($prefacturas as $prefactura):?>	  
			   
              <tr>			   
			   <td><?php
			   //echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/prefactura-fija/view?id='.$prefactura->id.'&dependencia='.$codigo_dependencia,['title'=>'ver']);
			   if(in_array("prefactura", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-pencil"></i>',Yii::$app->request->baseUrl.'/prefactura-fija/update?id='.$prefactura->id);
  
			   }
               
			   if(in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/prefactura-fija/delete?id='.$prefactura->id.'&dependencia='.$codigo_dependencia,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar este elemento']);
  
			   }
			   
			   //echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/siniestro/update?id='.$siniestro->id);
               //echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/siniestro/delete?id='.$siniestro->id,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $prefactura->ano?></td>
     			<td><?= $prefactura->mes?></td>
				
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
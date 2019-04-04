<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas Semestrales';
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}
?>
    <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'visita' => $visita]) ?>
	
	<div class="form-group">

	<?= Html::a('Solicitud o Activación',Yii::$app->request->baseUrl.'/centro-costo/evento?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	<?= Html::a('Quincenales',Yii::$app->request->baseUrl.'/centro-costo/visita?id='.$codigo_dependencia,['class'=>'btn btn-primary']) ?>
	</div>	
	<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
        
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Codigo</th>
           <th>Fecha</th>
		   <th>Creada</th>
		   <th>Observaciones</th>
          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($visitas as $visita):?>	  
			   
              <tr>			   
			   <td><?php
			   echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/visita-mensual/view?id='.$visita->id.'&dependencia='.$codigo_dependencia,['title'=>'ver']);
               
			   if(in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/visita-dia/delete?id='.$visita->id.'&dependencia='.$codigo_dependencia,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar este elemento']);
  
			   }
			   
			   //echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/siniestro/update?id='.$siniestro->id);
               //echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/siniestro/delete?id='.$siniestro->id,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $visita->id?></td>
     			<td><?= $visita->fecha?></td>
				<td><?= $visita->usuario?></td>
				<td><?= $visita->detalle?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Dependencias';
$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
  $permisos = Yii::$app->session['permisos-exito'];
}
?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">
    <?php if(in_array("dependencia-create", $permisos)):?>
	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/centro-costo/create',['class'=>'btn btn-primary']) ?>
	<?php endif;?>	
	</div>	
    
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Codigo</th>
           <th>Nombre</th>
		   <th>Marca</th>
		   <th>Ciudad</th>
           <th>Dirección</th>
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($dependencias as $dependencia):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/update?id='.$dependencia->codigo);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/delete?id='.$dependencia->codigo,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $dependencia->codigo?></td>
     			<td><?= $dependencia->nombre?></td>
				<td><?= $dependencia->marca->nombre?></td>
				<td><?= $dependencia->ciudad->nombre?></td>
				<td><?= $dependencia->direccion?></td>
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>

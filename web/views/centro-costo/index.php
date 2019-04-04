<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dependencias';
//var_dump(Yii::$app->session->getTimeout());
$permisos = array();

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

$ciudades_zonas = array();

foreach($zonasUsuario as $zona){
	
     $ciudades_zonas [] = $zona->zona->ciudades;	
	
}

$ciudades_permitidas = array();

foreach($ciudades_zonas as $ciudades){
	
	foreach($ciudades as $ciudad){
		
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		
	}
	
}

$marcas_permitidas = array();

foreach($marcasUsuario as $marca){
	
		
		$marcas_permitidas [] = $marca->marca_id;

}

$dependencias_distritos = array();

foreach($distritosUsuario as $distrito){
	
     $dependencias_distritos [] = $distrito->distrito->dependencias;	
	
}

$dependencias_permitidas = array();

foreach($dependencias_distritos as $dependencias0){
	
	foreach($dependencias0 as $dependencia0){
		
		$dependencias_permitidas [] = $dependencia0->dependencia->codigo;
		
	}
	
}

$tamano_dependencias_permitidas = count($dependencias_permitidas);

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">
    <?php if(in_array("dependencia-create", $permisos)):?>
	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/centro-costo/create',['class'=>'btn btn-primary']) ?>
	<?php endif;?>	
	</div>	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>CeBe</th>
		   <th>CeCo</th>
           <th>Nombre</th>
		   <th>Marca</th>
		   <th>Ciudad</th>
          
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($dependencias as $dependencia):?>	  
			  
              <?php if(in_array($dependencia->ciudad_codigo_dane,$ciudades_permitidas) ):?>			  
                
				<?php if(in_array($dependencia->marca_id,$marcas_permitidas) ):?>			  
				
				  <?php if($tamano_dependencias_permitidas > 0):?>	

                     <?php if(in_array($dependencia->codigo,$dependencias_permitidas) ):?>			  				  
						  <tr>			   
						   <td><?php
						   
						   echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$dependencia->codigo,['title'=>'ver']);
						   echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/update?id='.$dependencia->codigo);
						   if(in_array("dependencia-create", $permisos)){
							
							echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/delete?id='.$dependencia->codigo,['data-method'=>'post']);  
						   }
						   
							

								?>
							</td>
							<td><?= $dependencia->cebe?></td>
							<td><?= $dependencia->ceco?></td>
							<td><?= $dependencia->nombre?></td>
							<td><?= $dependencia->marca->nombre?></td>
							<td><?= $dependencia->ciudad->nombre?></td>
							
						  </tr>
						
					  <?php else:?>	  	
						  <tr>			   
						   <td><?php
						   
						   echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$dependencia->codigo,['title'=>'ver']);
						   echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/update?id='.$dependencia->codigo);
						   if(in_array("dependencia-create", $permisos)){
							
							echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/delete?id='.$dependencia->codigo,['data-method'=>'post']);  
						   }
								?>
							</td>
							<td><?= $dependencia->cebe?></td>
							<td><?= $dependencia->ceco?></td>
							<td><?= $dependencia->nombre?></td>
							<td><?= $dependencia->marca->nombre?></td>
							<td><?= $dependencia->ciudad->nombre?></td>
							
						  </tr>						  
					  <?php endif;?>	  
				  
				  <?php else:?>
				  
					 <tr>			   
					   <td><?php
					   
					   echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$dependencia->codigo,['title'=>'ver']);
                       echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/update?id='.$dependencia->codigo);						
						if(in_array("dependencia-create", $permisos)){
							
							echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/centro-costo/delete?id='.$dependencia->codigo,['data-method'=>'post']);  
						   }
							?>
						</td>
							<td><?= $dependencia->cebe?></td>
							<td><?= $dependencia->ceco?></td>
							<td><?= $dependencia->nombre?></td>
							<td><?= $dependencia->marca->nombre?></td>
							<td><?= $dependencia->ciudad->nombre?></td>
						
					  </tr>				  
				  
				  <?php endif;?>
				  
			     <?php endif;?>
			 
			 <?php endif;?>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
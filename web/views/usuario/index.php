<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">

	<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/usuario/create',['class'=>'btn btn-primary']) ?>
		
	</div>	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Usuario</th>
           <th>Nombre</th>
		   <th>Email</th>
		   <th>Cargo</th>
		   <th>Regional</th>
		   <th>Area</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($usuarios as $usuario):?>	  
			   
              <tr>			   
			   <td><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/usuario/update?id='.$usuario->usuario);
                echo Html::a('<i class="fa fa-plus fa-fw"></i>',Yii::$app->request->baseUrl.'/usuario/actividades-macro?id='.$usuario->usuario);
				echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/usuario/delete?id='.$usuario->usuario,['data-method'=>'post']);

                    ?>
				</td>
                
     			<td><?= $usuario->usuario?></td>
				<td><?= $usuario->nombres.' '.$usuario->apellidos?></td>
				<td><?= $usuario->email?></td>
				<td><?= $usuario->cargo?></td>
				<td><?php 
				
				    $zonas = $usuario->zonas;
					
					if($zonas != null){
						
						echo $zonas[0]->zona->nombre;
						
					}
				   
				
				?>
				
				</td>
				<td><?= $usuario->area?></td>
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
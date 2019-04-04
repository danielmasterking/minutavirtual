<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mermas '.$usuario;
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
<?= $this->render('_tabs',['investigaciones' => $investigaciones,'usuario' => $usuario]) ?>

	<div class="form-group">

	<?= Html::a('Incidentes',Yii::$app->request->baseUrl.'/usuario/incidente?id='.$usuario,['class'=>'btn btn-primary']) ?>
		
	</div>	   

   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Código</th>
           <th>Fecha</th>
		   <th>Dependencia</th>
		   <th>Usuario</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($mermas_usuario as $key):?>	  
			   

			   
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/merma/view-from-cordinador?id='.$key->id);
            	if(in_array("administrador", $permisos) ){
				   
				  // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/merma/delete-from-cordinador?id='.$key->id.'&usuario='.$key->usuario,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar elemento']);
  
			     }
                    ?>
				</td>
                
     			<td><?= $key->id?></td>
				<td><?= $key->fecha?></td>
				<td><?=$key->mermaDependencias[0]->dependencia->nombre?></td>
				<td><?= $key->usuario?></td>
              </tr>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
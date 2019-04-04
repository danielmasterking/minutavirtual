<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas Semestrales '.$usuario;
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}
?>
<?= $this->render('_tabs',['visitas' => $visitas,'usuario' => $usuario]) ?>

	<div class="form-group">

	<?= Html::a('Solicitud o Activación',Yii::$app->request->baseUrl.'/usuario/evento?id='.$usuario,['class'=>'btn btn-primary']) ?>
	<?= Html::a('Visitas Quincenales',Yii::$app->request->baseUrl.'/usuario/visita?id='.$usuario,['class'=>'btn btn-primary']) ?>
		
	</div>	   

   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Código</th>
           <th>Fecha Visita</th>
		   <th>Dependencia</th>
		   <th>Usuario</th>
		   <th>Archivo</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($visitas_usuario as $visita):?>	  
			   
			   
              
			  <tr>			   
			   <td><?php
                
				$archivos = $visita->archivos;
				
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/visita-mensual/view-from-cordinador?id='.$visita->id);
            	if( in_array("administrador", $permisos) ){
				   
				  // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/visita-mensual/delete-from-cordinador?id='.$visita->id.'&usuario='.$visita->usuario,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar elemento']);
  
			     }
                    ?>
				</td>
                
     			<td><?= $visita->id?></td>
				<td><?= $visita->fecha_visita?></td>
				<td><?= $visita->dependencia->nombre?></td>
				<td><?= $visita->usuario?></td>
				<td>
				    <?php if($archivos != null):?>
     				<a href="http://cvsc.com.co/sgs/web<?=$archivos[0]->archivo?>" download>
					 <?=$archivos[0]->archivo?>
					</a>
					<?php endif;?>
				</td>
              </tr>
			  
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
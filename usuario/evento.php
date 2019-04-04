<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas por solicitud o activación '.$usuario;
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
<div class="container" style="margin-top:5px;padding-top:5px;">
<?= $this->render('_cambio') ?>
<div class="row">

<?= $this->render('_menu2') ?>

<div class="col-md-9">

<?= $this->render('_tabs',['visitas' => $visitas,'usuario' => $usuario]) ?>

	<div class="form-group">

	<?= Html::a('Visitas períodicas',Yii::$app->request->baseUrl.'/usuario/visita?id='.$usuario,['class'=>'btn btn-primary']) ?>
		
	</div>	   

   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Código</th>
           <th>Fecha</th>
		   <th>Tipo de solicitud</th>
		   <th>Usuario</th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($visitas_usuario as $visita):?>	  
			   
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/evento/view?id='.$visita->id);
            	if($visita->usuario == Yii::$app->session['usuario-exito'] || in_array("administrador", $permisos) ){
				   
				  // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/evento/delete-from-cordinador?id='.$visita->id.'&usuario='.$visita->usuario,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar elemento']);
  
			     }
                    ?>
				</td>
                
     			<td><?= $visita->id?></td>
				<td><?= $visita->fecha?></td>
				<td><?= $visita->novedad->nombre?></td>
				<td><?= $visita->usuario?></td>
              </tr>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
    
</div>



</div>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Siniestros '.$usuario;
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
<div class="container" style="margin-top:5px;padding-top:5px;">
<?= $this->render('_cambio') ?>
<div class="row">

<?= $this->render('_menu2') ?>

<div class="col-md-9">

<?= $this->render('_tabs',['siniestros' => $siniestros,'usuario' => $usuario]) ?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Código</th>
           <th>Fecha</th>
		   <th>Tipo</th>
		   <th>Dependencia</th>
		   <th>Usuario</th>
		   
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($siniestros_usuario as $siniestro):?>	  
			   
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/siniestro/view-from-cordinador?id='.$siniestro->id);
               if($siniestro->usuario == Yii::$app->session['usuario-exito'] || in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/siniestro/delete-from-cordinador?id='.$siniestro->id.'&usuario='.$siniestro->usuario,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
  
			   }
                    ?>
				</td>
                
     			<td><?= $siniestro->id?></td>
				<td><?= $siniestro->fecha?></td>
				<td><?= $siniestro->novedad->nombre?></td>
				<td><?= $siniestro->dependencia->nombre?></td>
				<td><?= $siniestro->usuario?></td>
				
              </tr>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
    
</div>



</div>

</div>

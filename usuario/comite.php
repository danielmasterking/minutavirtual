<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comités '.$usuario;
if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
<div class="container" style="margin-top:5px;padding-top:5px;">
<?= $this->render('_cambio') ?>
<div class="row">

<?= $this->render('_menu2') ?>

<div class="col-md-9">

<?= $this->render('_tabs',['comites' => $comites,'usuario' => $usuario]) ?>

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
	   
             <?php foreach($comites_usuario as $comite):?>	  
			   
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/comite/view-from-cordinador?id='.$comite->id);
               if($comite->usuario == Yii::$app->session['usuario-exito'] || in_array("administrador", $permisos) ){
				   
				 // echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update?id='.$capacitacion->capacitacion_id);
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/comite/delete-from-cordinador?id='.$comite->id.'&usuario='.$comite->usuario,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
  
			   }
                    ?>
				</td>
                
     			<td><?= $comite->id?></td>
				<td><?= $comite->fecha?></td>
				<td><?= $comite->novedad->nombre?></td>
				<td><?php
				   
				   $dependencias = $comite->dependencias;
				   
				   if($dependencias != null){
					   
					   
					   echo $dependencias[0]->dependencia->nombre;
					   
				   }
				
				
				?></td>
				<td><?= $comite->usuario?></td>
              </tr>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
    
</div>

</div>

</div>

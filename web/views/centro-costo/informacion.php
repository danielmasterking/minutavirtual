<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Información dependencia';

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

?>
    <?= $this->render('_tabsDependencia',['codigo_dependencia' => $codigo_dependencia,'informacion' => $informacion]) ?>

      
<p>&nbsp;</p>

<div class="form-group">


<?= Html::a('<i class="fa fa-pencil"> Cambiar Imagen</i>',Yii::$app->request->baseUrl.'/centro-costo/imagen?id='.$codigo_dependencia,['class'=>'btn btn-primary pull-right']) ?>  

</div>   

<div class="row">

   <div class="col-md-6">
   
      <?php $ruta = $model->foto == null ? ' ' : $model->foto;
        $ruta = Yii::$app->request->baseUrl.$ruta; 


     ?> 
     
	 <?php if(in_array("administrador", $permisos)):?>
	    
		<?php echo Html::a('<i class="fa fa-remove"></i> Eliminar Imagen',Yii::$app->request->baseUrl.'/centro-costo/delete-imagen?id='.$codigo_dependencia,['data-method'=>'post', 'data-confirm' => 'Está seguro de eliminar está imagen', 'class' => 'btn btn-default']); ?>
	    <p>&nbsp;</p>
	 <?php endif;?>
	 
	 
	 <img alt="imagen" class="img-responsive img-thumbnail" src="<?= $ruta ?>" />
   
   </div>
   
   <div class="col-md-6">
   
    <p ><strong>Dependencia:</strong> <?= $model->nombre?></p>
    <p ><strong>Ciudad:</strong> <?= $model->ciudad->nombre?></p>
    <p ><strong>Dirección:</strong> <?= $model->direccion?></p>
	<p ><strong>Teléfono:</strong> <?= $model->telefono?></p>
	<p ><strong>Empresa Seguridad:</strong> <?php if( $model->emp != null ){echo  $model->emp->nombre;} ?></p>
   
   
   </div>


</div>

<h3 style="text-align: center;">Contactos </h3>	  

  <div class="form-group">

   <?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/responsable/create?id='.$codigo_dependencia,['class'=>'btn btn-primary pull-right']) ?>  
    
  </div>
  
  <p>&nbsp;</p>
	 <table  class="table" cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Nombre</th>
		   <th>Cargo</th>
		   <th>Teléfono</th>
           <th>Email</th>
		   
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($responsables as $responsable):?>	  
			   
              <tr>			   
			   <td><?php
			   //echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/responsable/create?id='.$codigo_dependencia,['title'=>'ver']);
               echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/responsable/update?id='.$responsable->id.'&codigo='.$codigo_dependencia);
               echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/responsable/delete?id='.$responsable->id.'&codigo='.$codigo_dependencia,['data-method'=>'post']);

                    ?>
				</td>
                <td><?= $responsable->nombre?></td>
				
				<td><?= $responsable->cargo?></td>
				
				<td><?= $responsable->telefono?></td>
     			
				<td><?= $responsable->email?></td>
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
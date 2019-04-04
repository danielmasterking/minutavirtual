<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auditoría de Coordinadores';

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

$zonas = $active_user->zonas;
$zonaPrincipal = '';
if($zonas != null){
	
	$zonaPrincipal = $zonas[0]->zona->nombre;	
	
}


?>
<div class="container" style="margin-top:5px;padding-top:5px;">
<?= $this->render('_cambio') ?>
<div class="row">

<?= $this->render('_menu2') ?>
<div class="col-md-9">

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>

           <th>Nombre</th>
		   <th>Cargo</th>
		   <th>Regional</th>
   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($usuarios as $usuario):?>	  
			   
			   <?php if($usuario->usuario != 'admin'): ?>
			   
			   <?php
			       //validar roles
				   if( in_array("administrador", $permisos) ){
				
				?>							   			   
				  <tr>			   
				   <td><?php
					
					echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/usuario/capacitacion?id='.$usuario->usuario);

						?>
					</td>
					
					<td><?= $usuario->nombres.' '.$usuario->apellidos?></td>
					<td><?= $usuario->cargo?></td>
					
					<?php 
					
					   $tmp = $usuario->zonas;
					   $zona_tmp = '';
					   if($tmp != null){
						   
						   $zona_tmp = $tmp[0]->zona->nombre;
						   
					   }
					?>
					
					<td><?= $zona_tmp?></td>
					

				  </tr>
				
				<?php
					   
				   }else{
					   
					   $zonasCurrentUser = $usuario->zonas;
					   
					   if($zonasCurrentUser != null){
						   
						   if($zonasCurrentUser[0]->zona->nombre == $zonaPrincipal){
							   
							   ?>
							   
								  <tr>			   
								   <td><?php
									
									echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/usuario/capacitacion?id='.$usuario->usuario);

										?>
									</td>
									
									<td><?= $usuario->nombres.' '.$usuario->apellidos?></td>
									<td><?= $usuario->cargo?></td>
									
									<?php 
									
									   $tmp = $usuario->zonas;
									   $zona_tmp = '';
									   if($tmp != null){
										   
										   $zona_tmp = $tmp[0]->zona->nombre;
										   
									   }
									?>
									
									<td><?= $zona_tmp?></td>
									

								  </tr>							   
							   
							   
							   <?php
							   
							   
						   }
						   
					   }
					   
					   
				   }
			   
			   ?>

			  <?php endif;?>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
    
</div>

</div>

</div>

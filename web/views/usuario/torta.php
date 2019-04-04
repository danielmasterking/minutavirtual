<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cliente;
use yii\web\JsExpression;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;


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

$roles = $active_user->roles;
$roles_array = array();

foreach($roles as $key){
	
	$roles_array [] = $key->rol->id;
	
	
}



 $string = '[';
 
 	$total = 0;
	
	$sw = 0;
	
	$datos = array();
	
	foreach($consolidadoCapacitaciones as $key){

        $can = $key['TOTAL'] * 1;
		
		if($sw == 0){
			
			$datos = [ 'name' => 'Brands', 'colorBypoint' => true, 'data' => []];
			$sw = 1;
			
		}
		
		$total += $can;
		
				
	} 

	
	foreach($consolidadoCapacitaciones as $key){

		
		$can = $key['TOTAL'] * 1;
		
		$porcentaje = ($can/$total) * 100 ;

		$datos['data'] [] = ['name' => $key['TEMA'], 'y' => $porcentaje];

	
	} 
	
	$datos1 [] =  $datos;
	
	$datos = $datos1;


	
?>
<form method="post"> 


<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

 	<div class="form-group">

	<?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i>',Yii::$app->request->baseUrl.'/usuario/cordinadores',['class'=>'btn btn-primary']) ?>
		
	</div>	  
 
 <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	
       <div class="col-md-12">
	   
	   
	   	 <div class="col-md-3">
			 
			   <select class="form-control" id="regional" name="regional">
			 
			    <?php
				    
					foreach($regionales as $key){
						
						  if($key->id == $selected){
							  
						?>
						
						<option selected="selected" value="<?=$key->id?>"><?=$key->nombre?></option>		

                        <?php						
							  
						  }else{
							  
						?>
						
						<option value="<?=$key->id?>"><?=$key->nombre?></option>			


                         <?php						
							  
							  
							  
						  }
									
						
					}
				
				?>
			 
			    </select>
			 
			 </div>
	   
	   
	   
	   
		   <div class="col-md-3">
		   
		     <?php


					 echo DateControl::widget([
					'name'=>'fecha_inicial', 
					'type'=>DateControl::FORMAT_DATE,
					'autoWidget' => true,
					
					'displayFormat' => 'php:Y-m-d',
					'saveFormat' => 'php:Y-m-d'

				     ]);



		     ?>
		   
		   
		   </div>
		   
		   <div class="col-md-3">
		   
		     <?php


					 echo DateControl::widget([
					'name'=>'fecha_final', 
					'type'=>DateControl::FORMAT_DATE,
					'autoWidget' => true,
					
					'displayFormat' => 'php:Y-m-d',
					'saveFormat' => 'php:Y-m-d'

				     ]);



		     ?>
			 
		   </div>
		   
		   <div class="col-md-3">
		   
		     <input type="submit" name="consultar" class="btn btn-primary" value="Consultar"/>
			 
		   </div>
	   
	   </div>	
	
	<div class="col-md-12">
		
		<?php
			
			
			if(in_array(1,$roles_array)){

				echo Highcharts::widget([
								'scripts' => [
									'modules/exporting',
									'themes/grid-light',
								],
								'options' => [

									'chart' => [
									
								      'plotBackgroundColor' => null,
                                      'plotBorderWidth' => null,
                                      'plotShadow' => false,
									  'type' => 'pie',
									],
									'title' => [
										'text' => 'Capacitaciones por tema',
									],
									
									'tooltip' => [
									         
											 'pointFormat' => '<b>{point.percentage:.1f}%</b>'
									
									],
									
									'plotOptions' => [
									
									     'pie' => [
										     'allowPointSelect' => true,
											 'cursor' => 'pointer',
											 'dataLabels' => [ 'enabled' => false ],
											 'showInLegend' => true
										 
										 ],
										 
										 
									
									
									],
						
									

									'series' => $datos,
								]
							]);
							
								
								
				 }

			    ?>
	
	
	</div>
	
    
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
	 	 
</form>
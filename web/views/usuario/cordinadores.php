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

$roles_usuario_actual = $active_user->roles;
$data_rol = array();

foreach($roles_usuario_actual as $key){
	
  $data_rol [] = $key->rol_id;	
	
	
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
 
	foreach($consolidadoCapacitaciones as $key){

		$can = $key['TOTAL'] * 1;
		
		$datos [] = [ 'name' => $key['REGIONAL'], 'data' => [$can] ];
		
		$string .= $key['TOTAL'].',';	
		
	} 
	
	foreach($consolidadoComites as $key){

		
		$can = $key['TOTAL'] * 1;
	
		$string .= $key['TOTAL'].',';	
		
		$tamano_datos = count($datos);
		
		for($i = 0; $i < $tamano_datos; $i++ ){
			
			
			
			if($datos[$i]['name'] == $key['REGIONAL']){
				
				//$tem [] = array_push($x['data'],$can);
				
				
				$datos[$i]['data'] [] = $can;
				
				//var_dump(key($x));
				
			}
			
		}
	
	} 
	
	//Visitas Períodicas
	
	foreach($consolidadoVisitas as $key){

		
		$can = $key['TOTAL'] * 1;
	
		$string .= $key['TOTAL'].',';	
		
		$tamano_datos = count($datos);
		
		for($i = 0; $i < $tamano_datos; $i++ ){
			
			
			
			if($datos[$i]['name'] == $key['REGIONAL']){
				
				//$tem [] = array_push($x['data'],$can);
				
				
				$datos[$i]['data'] [] = $can;
				
				//var_dump(key($x));
				
			}
			
		}
	
	} 
	
	//Sumar Visitas Mensuales a vi
	
/*	foreach($consolidadoSiniestros as $key){

		
		$can = $key['TOTAL'] * 1;
	
		$string .= $key['TOTAL'].',';	
		
		$tamano_datos = count($datos);
		
		for($i = 0; $i < $tamano_datos; $i++ ){
			
			
			
			if($datos[$i]['name'] == $key['REGIONAL']){
				
				//$tem [] = array_push($x['data'],$can);
				
				
				$datos[$i]['data'] [] = $can;
				
				//var_dump(key($x));
				
			}
			
		}
	
	} */
	
	foreach($consolidadoIncidentes as $key){

		
		$can = $key['TOTAL'] * 1;
	
		$string .= $key['TOTAL'].',';	
		
		$tamano_datos = count($datos);
		
		for($i = 0; $i < $tamano_datos; $i++ ){
			
			
			
			if($datos[$i]['name'] == $key['REGIONAL']){
				
				//$tem [] = array_push($x['data'],$can);
				
				
				$datos[$i]['data'] [] = $can;
				
				//var_dump(key($x));
				
			}
			
		}
	
	} 	
//	var_dump($datos);


	
?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	

	
	<p>&nbsp;</p>
	<div class="col-md-12">
	
			<?php
			
			
			if(in_array(1,$roles_array)){
			
            ?>
			
			<div class="form-group">

			<?= Html::a('Temas capacitación',Yii::$app->request->baseUrl.'/usuario/cordinadores-torta',['class'=>'btn btn-primary']) ?>
				
			</div>	  
			
			<form method="post"> 
			   
			   
			   <div class="col-md-12">
			   
				   <div class="col-md-4">
				   
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
				   
				   <div class="col-md-4">
				   
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
				   
				   <div class="col-md-4">
				   
					 <input type="submit" name="consultar" class="btn btn-primary" value="Consultar"/>
					 
				   </div>
			   
			   </div>
				<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

			</form>			


            <?php			
				
				

				echo Highcharts::widget([
								'scripts' => [
									'modules/exporting',
									'themes/grid-light',
								],
								'options' => [

									'chart' => [
									  'type' => 'column',
									],
									'title' => [
										'text' => 'Balance de uso SGS año en curso',
									],

									'xAxis' => [
										'categories' => [
														'Capacitaciones',
														'Comités',
														'Visitas',
														'Investigaciones'
														
													],
										'crosshair' => 'true',			
									],
									
									'yAxis' => [
										'title' => [
														'text' => 'Cantidad'
														
													],
										'min' => '0',			
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
						   
						   if($zonasCurrentUser[0]->zona->nombre == $zonaPrincipal && ( in_array(2,$data_rol) || in_array(19,$data_rol) ) ){
							   
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
							   
							   if($usuario->usuario == $active_user->usuario){
								   
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
					   
					   
				   }
			   
			   ?>

			  <?php endif;?>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
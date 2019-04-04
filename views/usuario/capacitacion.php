<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Capacitaciones '.$usuario;

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}

$datos = array();

foreach($consolidadoCoordinadores as $key){

	$can = $key['TOTAL'] * 1;
	
	$datos [] = [ 'name' => $key['USER'], 'data' => [$can] ];
	

	
} 

$total = 0;

$sw = 0;


$datos1 = array();

foreach($consolidadoTemas as $key){

	$can = $key['TOTAL'] * 1;
	
	if($sw == 0){
		
		$datos1 = [ 'name' => 'Brands', 'colorBypoint' => true, 'data' => []];
		$sw = 1;
		
	}
	
	$total += $can;
	
			
} 


foreach($consolidadoTemas as $key){

	
	$can = $key['TOTAL'] * 1;
	
	$porcentaje = ($can/$total) * 100 ;

	$datos1['data'] [] = ['name' => $key['TEMA'], 'y' => $porcentaje];


} 


$datos2 [] =  $datos1;

$datos1 = $datos2;


?>
<?= $this->render('_tabs',['capacitaciones' => $capacitaciones,'usuario' => $usuario]) ?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<form method="post"> 
       
	 <?php  if( count($consolidadoCoordinadores) > 0 ): ?>
	 
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
		<p>&nbsp;</p>
	<div class="col-md-12">
	
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
										'text' => 'Balance de uso SGS',
									],

									'xAxis' => [
										'categories' => [
														'Capacitaciones',
														
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


			    ?>
	
	
	</div>
	
	<p>&nbsp;</p>	
	

	
	<div class="col-md-12">
		
		<?php


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

									'series' => $datos1,
								]
							]);

			    ?>
	
	
	</div>	
	
	<p>&nbsp;</p>	
	
	<?php  endif; ?>
    
	 <table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Código</th>
           <th>Fecha</th>
		   <th>Tema</th>
		   <th>Dependencia</th>
		   <th>Usuario</th>
		   
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($capacitaciones_usuario as $capacitacion):?>	  
			   
			   
              <tr>			   
			   <td><?php
                
                echo Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/capacitacion/view-from-cordinador?id='.$capacitacion->id);
    
            	echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/capacitacion/update-from-cordinador?id='.$capacitacion->id);
				if(in_array("administrador", $permisos) ){
				   
				  
                  echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/capacitacion/delete-from-cordinador?id='.$capacitacion->id.'&usuario='.$capacitacion->usuario,['data-method'=>'post','data-confirm' => 'Está seguro de eliminar elemento']);
  
			     }
                    ?>
				</td>
                
     			<td><?= $capacitacion->id?></td>
				<td><?= $capacitacion->fecha?></td>
				<td><?= $capacitacion->novedad->nombre?></td>
				<td><?php
				   
				   $dependencias = $capacitacion->capacitacionDependencias;
				   
				   if($dependencias != null){
					   
					   
					   echo $dependencias[0]->dependencia->nombre;
					   
				   }
				
				
				?></td>
				<td><?= $capacitacion->usuario?></td>
				
              </tr>
			  
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
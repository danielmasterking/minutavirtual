<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;
date_default_timezone_set ( 'America/Bogota');
$fecha = date('Y-m-d',time());
/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consolidado de pedidos especiales';

$zonas_array = array();


//Armar id de pedidos
$contador_pedido = 1;
$contador_posicion = 1;
$index = 0;
$array_id = array();
$array_pos = array();
$cebe_anterior = '';
$proveedor_anterior = '';

foreach($pendientes as $pen){
	
	
	if($proveedor_anterior == '' && $cebe_anterior == ''){
		
		$proveedor_anterior = $pen->proveedor;
		$cebe_anterior = $pen->cebe;
		$array_id [] = $contador_pedido;
		$array_pos [] = $contador_posicion;
		
	}else{
		
		if($pen->proveedor == $proveedor_anterior && $pen->cebe == $cebe_anterior){
			
			$contador_posicion++;
			$array_id [] = $contador_pedido;
			$array_pos [] = $contador_posicion;
			
		}else{
			
			$contador_posicion = 1;
			$contador_pedido = $contador_pedido + 1;
			$array_id [] = $contador_pedido;
			$array_pos [] = $contador_posicion;
			$cebe_anterior = $pen->cebe;
			$proveedor_anterior = $pen->proveedor;
			
			
		}
		
	}
	
		
}


?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    
	<div class="form-group">
		
	</div>	
<?php $form2 = ActiveForm::begin(); ?>	 

   <div class="col-md-12">
   
      <div class="col-md-4">

         <?= Html::a('Normales',Yii::$app->request->baseUrl.'/pedido/consolidar',['class'=>'btn btn-primary']) ?>		
		
	  </div>   
   
      <div class="col-md-4">

         <input type="submit" name="generar" value="Realizar Equivalencia" class="btn btn-primary"/>	  
		
	  </div>
	  
	

      <div class="col-md-4">

         <input type="submit" name="finalizar" value="Finalizar" class="btn btn-primary"/>	  
		
	  </div>	  
   
   </div>
   
   <p>&nbsp;</p>
   
	 <table  class="display my-data2" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
       		<th>Repetido?</th>
           <th>Nota de Cabecera</th>
           <th>ID_PEDIDO</th>
		   <th>Documento Compras</th>
		   <th>Imputación</th>
		   <th>Material</th>           
		   <th>Cantidad</th>
		   <th>Fecha de entrega</th>
		   <th>Grupo de Compras</th>
		   <th>Dep Entrega</th>
		   <th>Cedula del Solicitante</th>
		   <th>Organización de compras</th>
		   <th>Cta contable</th>
		   <th>Ceco</th>
		   <th>Orden Interna</th>
		   <th>Descripción Articulo</th>
		   <th>Observaciones Articulo</th>
		   <th>Código Activo Fijo</th>
		   <th>División</th>
		   <th>CeBe</th>
		   <th>Sublinea</th>
		   <th>Solicitante</th>
              
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	
			  
              <tr>	
			    <td>
			    	<?php
					  //validar repetidos;
					  if($pendiente->repetido=='SI'){
						  echo '<label style="color: red;">R</label>';
					  }
					?>
			    </td>
                <td><?= $pendiente->pedido->observaciones?></td>			
                <td><?= $array_id[$index] ?></td>	
				<td>ZNB</td>				
				<td><?= $pendiente->imputacion?></td>                				
				<td><?= $pendiente->maestra->material?></td>
				<td><?= $pendiente->cantidad?></td>										
				<td>				   
				   <?php				      
					  //$fecha = $pendiente->pedido->fecha;					  
					  
                        //Sumar 30 días						
						$nuevafecha = strtotime('+30 day', strtotime($fecha)); 
						$nuevafecha = date('Ymd',$nuevafecha);
						echo $nuevafecha;
		  
					  
						
										   				   
				   ?>

				</td>				
				<td></td>
				<td><?= $pendiente->pedido->dependencia->cebe?></td>
				<td>1036622675</td>
				<td>1004</td>
				<td><?= $pendiente->cuenta_contable?></td>
				<td><?= $pendiente->pedido->dependencia->ceco?></td>
				<td><?= $pendiente->orden_interna?></td>
				<td></td>
				<td><?= $pendiente->observaciones?></td>
				<td><?= $pendiente->codigo_activo?></td>
				<td></td>
				<td></td>
				<td></td>
			    <td><?= $pendiente->pedido->solicitante?></td>
              </tr>
			  <?php $index++; ?>		
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
 <?php ActiveForm::end(); ?>	
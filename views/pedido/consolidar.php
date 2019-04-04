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

$this->title = 'Consolidado de pedidos';

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
   
      <div class="col-md-3">

         <?= Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/consolidar-especial',['class'=>'btn btn-primary']) ?>		
		
	  </div>   
   
      <div class="col-md-3">

         <input type="submit" name="generar" value="Realizar Equivalencia" class="btn btn-primary"/>	  
		
	  </div>
	  
      <div class="col-md-3">

        <?= Html::a('Cabecera',Yii::$app->request->baseUrl.'/pedido/cabecera',['class'=>'btn btn-primary']) ?>		
	  
	  </div>	

      <div class="col-md-3">

         <input type="submit" name="finalizar" value="Finalizar" class="btn btn-primary"/>	  
		
	  </div>	  
   
   </div>
   
   <p>&nbsp;</p>
   
	 <table  class="display my-data2" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
       		<th>Repetido?</th>
           <th>ID_PEDIDO</th>
		   <th>Posicion</th>
		   <th>Material</th>
		   <th>Texto Breve</th>           
		   <th>Cantidad</th>
		   <th>unidad</th>
		   <th>ultima entrada</th>
		   <th>importe para bapis</th>
		   <th>Centro</th>
		   <th>Grupo</th>
		   <th>Almacen</th>
		   <th>Imputación</th>
		   <th>Solicitante</th>
		   <th>Indicador Iva</th>
		   <th>Fecha Entrega</th>
		   <th>Clase de condicion</th>
		   <th>Impte. Condición</th>
		   <th>Clave de moneda</th>
		   <th>Tipo de modificacion</th>
		   <th>Numero de cuenta mayor</th>
		   <th>Centro de Coste</th>
		   <th>Número de Orden</th>
		   <th>Contrato Asociado</th>
		   <th>Posición Contrato</th>
		   <th>Codigo activo Fijo</th>
		   <th>División</th>
		   <th>Cebe</th>
		   <th>Sublinea</th>
		   <th>Descripción por posición</th>


		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	

                <?php
                   
				   $regional = $pendiente->pedido->dependencia->ciudad->ciudadZonas;
				   $regional_id = '';
				   
				   if($regional != null){
					   
					   $regional_id = $regional[0]->zona->id;
				   }
				   
				   

                ?>				
			  
              
			  
              <tr>	
              	<td>
				<?php
				//validar repetidos;
				  if($pendiente->repetido=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?>
				</td>
                <td><?= $array_id[$index] ?></td>	
                <td>
                <?= $array_pos[$index] ?>
                </td>	
				<td>
				<?= $pendiente->producto->material?></td>				
				<td><?= $pendiente->producto->texto_breve?></td>    			
				<td><?= $pendiente->cantidad?></td>
				<td><?= $pendiente->producto->unidad_medida?></td>		
				<td></td>
				<td><?= $pendiente->precio_neto?></td>
				<td><?= $pendiente->pedido->dependencia->cebe?></td>
				<td></td>
				<td></td>
				<td><?= $pendiente->imputacion?></td>
				<td><?= $pendiente->pedido->solicitante?></td>
				<td><?= $pendiente->producto->indicador_iva?></td>
				
				<td>
				   
				   <?php
				      
					  //$fecha = $pendiente->pedido->fecha;
					  
					  if($pendiente->ordinario == 'S'){
						
                        //Sumar 30 días						
						$nuevafecha = strtotime('+30 day', strtotime($fecha)); 
						$nuevafecha = date('Ymd',$nuevafecha);
						echo $nuevafecha;

						
						  
					  }else{
						  
						 //Sumar 10 días
                         						
                        					
						$nuevafecha = strtotime('+10 day', strtotime($fecha)); 
						$nuevafecha = date('Ymd',$nuevafecha);
						echo $nuevafecha;						  
						  
					  }
				   
				   
				   ?>
				
				
				
				</td>
				
				
				<td>MWVS</td>
				<td>16</td>
			    <td><?= $pendiente->producto->moneda?></td>
				<td></td>
				<td><?= $pendiente->cuenta_contable?></td>
				<td><?= $pendiente->pedido->dependencia->ceco?></td>
				<td><?= $pendiente->orden_interna?></td>
				<td><?= $pendiente->producto->documento_compras?></td>
				<td><?= $pendiente->producto->posicion?></td>
				<td><?= $pendiente->codigo_activo?></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?= $pendiente->observaciones?></td>


				
              </tr>
			  <?php $index++; ?>		
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
 <?php ActiveForm::end(); ?>
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

$this->title = 'Archivo Cabecera';

$zonas_array = array();
date_default_timezone_set ( 'America/Bogota');
$fecha = date('dmY',time());

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
		$array_id [] = array('id' => $contador_pedido, 
		                     'fecha' => $fecha, 
							 'proveedor' => $pen->producto->maestra->proveedor->codigo,
                             'obs' => $pen->observaciones,
                             'responsable' => $pen->pedido->solicitante ) ;

		
	}else{
		
		if($pen->proveedor == $proveedor_anterior && $pen->cebe == $cebe_anterior){
			
		$array_id [] = array('id' => $contador_pedido, 
		                     'fecha' => $fecha, 
							 'proveedor' => $pen->producto->maestra->proveedor->codigo,
                             'obs' => $pen->observaciones,
                             'responsable' => $pen->pedido->solicitante ) ;

			
		}else{

			$contador_pedido = $contador_pedido + 1;
		    $array_id [] = array('id' => $contador_pedido, 
		                     'fecha' => $fecha, 
							 'proveedor' => $pen->producto->maestra->proveedor->codigo,
                             'obs' => $pen->observaciones,
                             'responsable' => $pen->pedido->solicitante ) ;
			$cebe_anterior = $pen->cebe;
			$proveedor_anterior = $pen->proveedor;
			
			
		}
		
	}
	
		
}

$cabecera = array();
$diferentes = array();


$tam = count($array_id);

for($i = 0; $i < $tam; $i++){
	
	if( !in_array($array_id[$i]['id'], $diferentes) ){
		
		$diferentes [] = $array_id[$i]['id'];
        $cabecera [] = $array_id[$i];		
		
	}
	
	
}

$tamano_cabecera = count($cabecera);

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    
	<div class="form-group">
		
	</div>	
<?php $form2 = ActiveForm::begin(); ?>	 

   <div class="col-md-12">
   
  
	   <?= Html::a('Items',Yii::$app->request->baseUrl.'/pedido/consolidar',['class'=>'btn btn-primary']) ?>		
	  
   
   </div>
   
   <p>&nbsp;</p>
   
	 <table  class="display my-data2" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>

           <th>ID_PEDIDO</th>
		   <th>Clase de Documento de compra</th>
		   <th>Fecha de creación</th>
		   <th>Número de cuenta proveedor</th>           
		   <th>Organización Compras</th>
		   <th>Grupo de compras</th>
		   <th>Clave de moneda</th>
		   <th>Compañia</th>
		   <th>Observaciones</th>
		   <th>Descripción General</th>
		   <th>Responsable</th>
		             
       </tr>
           

       </thead>	 
	   
	   <tbody>
           
		   <?php  for($i = 0; $i < $tamano_cabecera; $i++):?>
		   
		   <tr>
             
			 <td><?= $cabecera[$i]['id']?></td>
			 <td>ZNB</td>
			 <td><?=$cabecera[$i]['fecha']?></td>
			 <td><?= $cabecera[$i]['proveedor']?></td>
			 <td>1004</td>
			 <td>606</td>
			 <td>COP</td>
			 <td></td>
			 <td><?= $cabecera[$i]['obs']?></td>
			 <td></td>
			 <td><?= $cabecera[$i]['responsable']?></td>

           </tr>

           <?php endfor;?>		   
	   
	   </tbody>
	 
	 </table>
 <?php ActiveForm::end(); ?>
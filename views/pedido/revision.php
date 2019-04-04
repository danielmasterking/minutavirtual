<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Revisión de pedidos';

$zonas_array = array();

$marcas_array = array();

foreach($zonasUsuario as $key){
	
	$zonas_array [] = $key->zona->id;
	
}

foreach($marcasUsuario as $key){
	
	$marcas_array [] = $key->marca->id;
	
}

//var_dump($zonas_array);

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/revision-especial',['class'=>'btn btn-primary']) ?>		
	<div class="form-group">
		
	</div>	
<?php $form2 = ActiveForm::begin([
      	'id' => 'form-materiales',
    	]); ?>	 
    <div class="table-responsive">   
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           <th>Fecha Pedido</th>
           <th>Dependencia</th>
		   <th></th>
		   <th>Proveedor</th>
		   <th>Material</th>
		   <th>Texto Breve</th>
           <th>Cantidad</th>
		   
		   <th>Observaciones</th>
		   <th>Ordinario</th>
		   <th>Solicitante</th>
		   <th>
		   <a href="#" class="btn btn-primary" onclick="aprobarTodosProducto();return false">Seleccionados</a>
		   </th>
		   <th>
		   	<?= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-rechazo-todos">
                      <i class="fa fa-ban" aria-hidden="true"></i> Rechazo
                      </button>';
		   		Modal::begin([
                          'header' => '<h4>Motivo Rechazo</h4>',
                          'id' => 'modal-rechazo-todos',
                          'size' => 'modal-lg',
                          ]);
						 echo '<textarea name="mensaje-rechazo-todos" id="mensaje-rechazo-todos" class="form-control" rows="4"></textarea>';
                         echo '<p>&nbsp;</p>';
                         echo Html::a('Guardar', ['pedido/rechazar-producto-coordinador-todos'], ['data-method'=>'post','class' => 'btn btn-primary']);
                         Modal::end();
		   	?>
		   </th>
		   <th></th>
       </tr>
       </thead>	 
	   <tbody>
             <?php foreach($pendientes as $pendiente):?>
                <?php
				   $regional = $pendiente->pedido->dependencia->ciudad->ciudadZonas;
				   $regional_id = '';
				   $marca_id = $pendiente->pedido->dependencia->marca_id;
				   $contador_regionales = 0;
    			   if($regional != null){
	     			   $contador_regionales = count($regional);
				   }
				   $flag = false;
				   $metio='';
				   if($contador_regionales  < 2){
					  $flag = ( in_array($regional[0]->zona->id,$zonas_array) ) ? true : false;
					  $metio='contador_regionales';
				   }else{
					   $regionales_ids = array();
					   foreach($regional as $r){
						    $flag = ( in_array($r->zona->id,$zonas_array) ) ? true : false;
						    if(in_array($r->zona->id,$zonas_array)){
						    	$flag=true;break;
						    }else{
						    	$flag=false;
						    }
					   }
				   }
                ?>
              <?php 
              if($flag):?>
				  <?php if(in_array($marca_id,$marcas_array)):?>
				  <tr>
				  	<td><?= $pendiente->pedido->fecha ?></td>
					<td><?= $pendiente->pedido->dependencia->nombre?></td>
					<td>
						<?php if($pendiente->estado == 'E'):?>
						  <i class="fa fa-star" aria-hidden="true"></i>
						<?php endif;?>
						<?php
						//validar repetidos;
						  if($pendiente->repetido=='SI'){
							  echo '<label class="repetido" style="color: red;">R</label>';
						    }
						?>
					   <?= Html::checkBox('pedidos[]',false, ['value' => $pendiente->id, 'id'=>'materiales'])?>
					</td>
					<td><?= $pendiente->producto->maestra->proveedor->nombre?></td>
					<td><?= $pendiente->producto->material?></td>
					<td><?= $pendiente->producto->texto_breve?></td>
					<td><?= $pendiente->cantidad?></td>
					<td><?= $pendiente->observaciones?></td>
					<td><?= $pendiente->ordinario?></td>
					<td><?= strtoupper($pendiente->pedido->solicitante)?></td>
					<td>
					<a href="#" class="btn btn-primary aprobar<?=$pendiente->id?>" onclick="aprobarProducto('aprobar<?=$pendiente->id?>','<?=$pendiente->id?>');return false"><i class="fa fa-check" aria-hidden="true"></i></a>
					</td>
					<td>
					 <?php
						echo ' 
							 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-rechazo-'.$pendiente->id.'">
							 <i class="fa fa-ban" aria-hidden="true"></i>
							 </button>';
						 // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
						 Modal::begin([
						  'header' => '<h4>Motivo Rechazo</h4>',
						  'id' => 'modal-rechazo-'.$pendiente->id,
						  'size' => 'modal-lg',
						  ]);
						 echo '<input name="itemr-rechazo-'.$pendiente->id.'" id="itemr-rechazo-'.$pendiente->id.'" class="form-control" value="'.$pendiente->id.'"  type="hidden"/>';
						 echo '<textarea name="mensaje-rechazo-'.$pendiente->id.'" id="mensaje-rechazo-'.$pendiente->id.'" class="form-control" rows="4"></textarea>';
						 echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="rechazar" value="Guardar" class="btn btn-primary btn-lg"/>';
						 Modal::end();
					 ?>
					</td>
					<td>
					 <?php
						echo ' 
							 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-'.$pendiente->id.'">
							 <i class="fa fa-comment-o" aria-hidden="true"></i>
							 </button>';

						 // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
						 Modal::begin([

						  'header' => '<h4>Motivo</h4>',
						  'id' => 'modal-'.$pendiente->id,
						  'size' => 'modal-lg',

						  ]);
						 echo '<input name="item-'.$pendiente->id.'" id="item-'.$pendiente->id.'" class="form-control" value="'.$pendiente->id.'"  type="hidden"/>';
						 echo '<textarea name="mensaje-'.$pendiente->id.'" id="mensaje-'.$pendiente->id.'" class="form-control" rows="4">'.$pendiente->observacion_coordinador.'</textarea>';
						 echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
						 Modal::end();
					 ?>
					</td>
				  </tr>
				  <?php endif;?>
			  <?php endif;?>
        	 <?php endforeach; ?>
	   </tbody>
	 </table>
	</div>
 <?php ActiveForm::end(); ?>
 <script>
 	function aprobarProducto(clase,id){
 		var repetido=$('.'+clase).parent().parent().find('.repetido').html();
 		if(repetido=='R'){
 			var r = confirm("El Material Seleccionado es Repetido, ¿Desea Continuar?");
			if (r == true) {
			    location.href="<?php echo Url::toRoute('pedido/aprobar-producto?id_detalle_producto=')?>"+id;
			}
 		}else{
 			location.href="<?php echo Url::toRoute('pedido/aprobar-producto?id_detalle_producto=')?>"+id;
 		}
 	}
 	function aprobarTodosProducto(){
 		var repetido;var count=0;
 		$('input:checked').each(function() {
		    repetido=$(this).parent().find('.repetido').html();
		    if(repetido=='R'){
		    	count++;return;
		    }
		});
		var form=document.getElementById("form-materiales");
        form.action="<?php echo Url::toRoute('pedido/aprobar-producto-coordinador-todos')?>";
 		if(count>0){
 			var r = confirm("Se encontraron Materiales Repetidos, ¿Desea Continuar?");
			if (r == true) {
				form.submit();
			}
 		}else{
 			form.submit();
 		}
 	}
 </script>
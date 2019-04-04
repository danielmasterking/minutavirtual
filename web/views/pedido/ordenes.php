<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agregar Orden de Compra';

?>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?= Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/orden-compra-especial',['class'=>'btn btn-primary']) ?>			
	<div class="form-group">
		
	</div>	
  <?php $form2 = ActiveForm::begin(); ?>	      
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           

		   <th>Id_pedido</th>
		   <th>posición</th>
		   <th>Dependencia CeBe</th>
		   <th>Dependencia</th>
           <th>Texto Breve</th>
		   <th>Cantidad</th>
		   <th>OC/No.Solicitud</th>		   
		   <th>Fecha de Creación</th>
		   <th></th>
		   <th></th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	  
			   
              <tr>			   

				<td><?= $pendiente->id_pedido?></td>
				<td><?= $pendiente->posicion?></td>
				<td>
				<?= $pendiente->pedido->dependencia->cebe?></td>
				<td>
				<?php
				//validar repetidos;
				  if($pendiente->repetido=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?>
				<?= $pendiente->pedido->dependencia->nombre?></td>
				<td><?= $pendiente->producto->texto_breve?></td>
     			<td><?= $pendiente->cantidad?></td>
				<td><?= $pendiente->orden_compra?></td>
				<td><?= $pendiente->pedido->fecha?></td>
				
				
				<td>
				
				 <?php
				 
				 
                        echo ' 
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-'.$pendiente->id.'">
                             <i class="fa fa-pencil" aria-hidden="true"></i>
                             </button>';

                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([

                          'header' => '<h4>Orden de Compra</h4>',
                          'id' => 'modal-'.$pendiente->id,
                          'size' => 'modal-lg',

                          ]);

                         echo '<input name="item-'.$pendiente->id.'" id="item-'.$pendiente->id.'" class="form-control" value="'.$pendiente->id.'"  type="hidden"/>';
						 echo '<textarea name="orden-'.$pendiente->id.'" id="orden-'.$pendiente->id.'" class="form-control" rows="4"></textarea>';
                         echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
                         Modal::end();
	 
				 ?>						
	
				</td>
				<td>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['pedido/orden-asignada?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>				
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
     <?php ActiveForm::end(); ?>
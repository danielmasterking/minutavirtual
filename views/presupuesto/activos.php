<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Revisión Financiera de pedidos';

?>
  <?= $this->render('_tabsFinanciera',['pedido' => $pedido]) ?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
	<div class="form-group">
		
	</div>	
 <?php $form2 = ActiveForm::begin(); ?>	   
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           <th></th>
		   <th>Material</th>
		   <th>Producto</th>
           <th>Cantidad</th>
		   <th>Dependencia</th>
		   <th>Observaciones</th>
		   <th>Imputación</th>
		   <th></th>
		   <th></th>
		   <th></th>
		   <th></th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	  
			   
              <tr>	

				<td>
				    <?php if($pendiente->estado == 'Z'):?>
					
					  <i class="fa fa-star" aria-hidden="true"></i>
					  
					<?php endif;?>
				

				
				</td>			  
                <td><?= $pendiente->producto->material?></td>
				<td><?= $pendiente->producto->texto_breve?></td>
     			<td><?= $pendiente->cantidad?></td>

				<td><?= $pendiente->pedido->dependencia->nombre?></td>
				<td><?= $pendiente->observaciones?></td>
				<td><?= $pendiente->imputacion?></td>
				<td>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('Activo', ['pedido/aprobar-producto-activo?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>
				<td>
				
				<?php Pjax::begin(); ?>
				  <?= Html::a('Gasto', ['pedido/aprobar-producto-gasto?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>
                
			   <td>
				
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', ['pedido/rechazar-producto-financiero?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
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
						 echo '<textarea name="mensaje-'.$pendiente->id.'" id="mensaje-'.$pendiente->id.'" class="form-control" rows="4">'.$pendiente->observacion_financiera.'</textarea>';
                         echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
                         Modal::end();

				 ?>						
				
	
				</td>				
				
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
 <?php ActiveForm::end(); ?>
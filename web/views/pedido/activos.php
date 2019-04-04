<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agregar código de activo.';

?>
<?= $this->render('_tabsFinanciera',['activos' => $activos]) ?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<?= Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/codigo-activos-especial',['class'=>'btn btn-primary']) ?>			
	<div class="form-group">
		
	</div>	
  <?php $form2 = ActiveForm::begin(); ?>	      
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           
           
		   <th>Dependencia</th>
		   <th></th>
		   <th>Producto</th>
		   <th>Cantidad</th>
           <th>Ceco</th>
		   <th>Costo Unitario</th>
		   
		   <th>Código activo</th>
		   
		   <th></th>
		   <th></th>
		   <th></th>
		   
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	  
			   
              <tr>			   

				<td><?= $pendiente->pedido->dependencia->nombre?></td>
				<td><?= $pendiente->producto->maestra->proveedor->nombre?></td>
				<td><?= $pendiente->producto->texto_breve?></td>
     			<td><?= $pendiente->cantidad?></td>
                <td><?= $pendiente->pedido->dependencia->ceco?></td>
				<td><?= $pendiente->precio_neto?></td>
				
				<td><?= $pendiente->codigo_activo?></td>
				
				<td>
				
				 <?php
				 
				 
                        echo ' 
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-'.$pendiente->id.'">
                             <i class="fa fa-pencil" aria-hidden="true"></i>
                             </button>';

                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([

                          'header' => '<h4>Código de activo</h4>',
                          'id' => 'modal-'.$pendiente->id,
                          'size' => 'modal-lg',

                          ]);

                         echo '<input name="item-'.$pendiente->id.'" id="item-'.$pendiente->id.'" class="form-control" value="'.$pendiente->id.'"  type="hidden"/>';
						 echo '<textarea name="activo-'.$pendiente->id.'" id="activo-'.$pendiente->id.'" class="form-control" rows="4"></textarea>';
                         echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
                         Modal::end();
	 
				 ?>						
	
				</td>
				<td>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['pedido/activo-asignado?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>		

				<td>
				<!-- Llamado ajax para devolver-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i>', ['pedido/regresar-financiera-from-activo?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>					
				
              </tr>
        	 <?php endforeach; ?>			 
	   
	   </tbody>
	 
	 </table>
     <?php ActiveForm::end(); ?>	
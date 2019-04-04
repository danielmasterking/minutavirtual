<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Revisión Técnica de pedidos';

?>
<?= $this->render('_tabsTecnica',['pedido' => $pedido]) ?>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
	
    <?= Html::a('Especiales',Yii::$app->request->baseUrl.'/pedido/revision-tecnica-especial',['class'=>'btn btn-primary']) ?>		
	
	<div class="form-group">
		
	</div>	
  <?php $form2 = ActiveForm::begin(); ?>	      
	 <table  class="display my-data" data-page-length='20' cellspacing="0" width="100%">
	 
       <thead>

       <tr>
           <th>Dependencia</th>
           <th></th>
		   <th></th>
		   <th>Producto</th>
           <th>Cantidad</th>
		   
		   <th>Observaciones</th>
		   <th>Solicitante</th>
		   <th><?= Html::a('Seleccionados', ['pedido/aprobar-producto-tecnico-todos'], ['data-method'=>'post','class' => 'btn btn-primary']);?></th>
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
                         echo Html::a('Guardar', ['pedido/rechazar-producto-tecnico-todos'], ['data-method'=>'post','class' => 'btn btn-primary']);
                         Modal::end();
		   	?>
		   </th>
		   <th></th>
           
       </tr>
           

       </thead>	 
	   
	   <tbody>
	   
             <?php foreach($pendientes as $pendiente):?>	  
			   
              <tr>			   
               <td><?= $pendiente->pedido->dependencia->nombre?></td>				
				<td>
				    <?php if($pendiente->estado == 'W'):?>
					
					  <i class="fa fa-star" aria-hidden="true"></i>
					  
					<?php endif;?>
				<?php
				//validar repetidos;
				  if($pendiente->repetido=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?>
                 <?= Html::checkBox('pedidos[]',false, ['value' => $pendiente->id])?>
				
				</td>
				<td><?= $pendiente->producto->maestra->proveedor->nombre?></td>
				<td><?= $pendiente->producto->texto_breve?></td>
     			<td><?= $pendiente->cantidad?></td>

				
				<td><?= $pendiente->observaciones?></td>
				<td><?= strtoupper($pendiente->pedido->solicitante)?></td>
				<td>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin(); ?>
				  <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['pedido/aprobar-producto-tecnico?id_detalle_producto='.$pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end(); ?>
				
				</td>
<!-- -->
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


<!-- -->
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
						 echo '<textarea name="mensaje-'.$pendiente->id.'" id="mensaje-'.$pendiente->id.'" class="form-control" rows="4">'.$pendiente->observacion_tecnica.'</textarea>';
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
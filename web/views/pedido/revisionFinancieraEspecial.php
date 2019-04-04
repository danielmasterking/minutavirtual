<?php

use kartik\money\MaskMoney;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$cebe_anterior = '';
$subtotal      = 0;
$subtotales    = array();

foreach ($pendientes as $pendiente) {
    // Calcular subtotal
    if ($cebe_anterior == '') {
        if ($pendiente->precio_sugerido > 0) {
            $subtotal = $pendiente->precio_sugerido * $pendiente->cantidad;
        } else {
            $subtotal = $pendiente->precio_neto * $pendiente->cantidad;
        }

        $cebe_anterior              = $pendiente->dep;
        $sucursales[]               = $cebe_anterior;
        $subtotales[$cebe_anterior] = $subtotal;
        $sw                         = false;

    } else {

        $tmp = $pendiente->dep;

        if ($tmp == $cebe_anterior) {
        	if ($pendiente->precio_sugerido > 0) {
	           $subtotales[$tmp] = $subtotales[$tmp] + $pendiente->precio_sugerido * $pendiente->cantidad;
	        } else {
	           $subtotales[$tmp] = $subtotales[$tmp] + $pendiente->precio_neto * $pendiente->cantidad;
	        }
        } else {
        	if ($pendiente->precio_sugerido > 0) {
	           $subtotal = $pendiente->precio_sugerido * $pendiente->cantidad;
	        } else {
	           $subtotal = $pendiente->precio_neto * $pendiente->cantidad;
	        }
            $sucursales[]     = $tmp;
            $subtotales[$tmp] = $subtotal;
            $subtotal         = 0;
            $cebe_anterior    = $tmp;

        }
    }

}

$cebe_anterior     = '';
$limite_subtotales = count($pendientes);
$index             = 0;
//var_dump($subtotales);
//var_dump($limite_subtotales);
$this->title = 'Revisión Financiera de pedidos Especiales';

?>
<?=$this->render('_tabsFinanciera', ['pedido' => $pedido])?>

<h1 style="text-align: center;"><?=Html::encode($this->title)?></h1>

<?=Html::a('Normales', Yii::$app->request->baseUrl . '/pedido/revision-financiera', ['class' => 'btn btn-primary'])?>

<?php $form2 = ActiveForm::begin();?>
	<table  class="display my-data" data-page-length='200' cellspacing="0" width="100%">
    <thead>
       <tr>
         <th>Dependencia</th>
  		   <th></th>
  		   <th>Material</th>
  		   <th>Producto</th>
         <th>Cant</th>
  		   <th>Cebe</th>
  		   <th>Regional</th>
  		   <th>Valor Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  		   <th>Valor Total producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
         <th>Solicitante</th>
         <th>Cotizacion</th>
         <th>
       		<?=Html::a('+Activos', ['pedido/aprobar-producto-activo-especial-todos'], ['data-method' => 'post', 'class' => 'btn btn-primary']);?>
  			 </th>
  		   <th>
       		<?=Html::a('+Gasto', ['pedido/aprobar-producto-gasto-especial-todos'], ['data-method' => 'post', 'class' => 'btn btn-primary']);?>
  		   </th>
  		   <th>
       		<?=Html::a('+Proyecto', ['pedido/aprobar-producto-proyecto-especial-todos'], ['data-method' => 'post', 'class' => 'btn btn-primary']);?>
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
                           echo Html::a('Guardar', ['pedido/rechazar-producto-especial-financiero-todos'], ['data-method'=>'post','class' => 'btn btn-primary']);
                           Modal::end();
              ?>      
             </th>
  		   <th></th>
       </tr>
       </thead>
	   <tbody>
             <?php foreach ($pendientes as $pendiente): ?>
      <tr>
				<td><?=$pendiente->pedido->dependencia->nombre?></td>

				<td>
				    <?php if ($pendiente->estado == 'Z'): ?>

					  <i class="fa fa-star" aria-hidden="true"></i>

					<?php endif;?>
                  <?php
            //validar repetidos;
            if($pendiente->repetido=='SI'){
              echo '<label style="color: red;">R</label>';
            }
          ?>
                 <?=Html::checkBox('pedidos[]', false, ['value' => $pendiente->id])?>


				</td>

                <?php

$regional        = $pendiente->pedido->dependencia->ciudad->ciudadZonas;
$regional_nombre = '';

if ($regional != null) {

    $regional_nombre = $regional[0]->zona->nombre;
}

?>

				<td><?=$pendiente->maestra->material . '-' . $pendiente->maestra->texto_breve?></td>
			    <td><?=$pendiente->producto_sugerido?></td>
				<td><?=$pendiente->cantidad?></td>

				<td><?=$pendiente->pedido->dependencia->cebe?></td>
				<td><?=$regional_nombre?></td>

				<td>
				<?php
        if($pendiente->precio_sugerido>0){
            echo MaskMoney::widget([
                    'name'    => 'valor1-view' . $pendiente->id,
                    'value'   => $pendiente->precio_sugerido,
                    'options' => ['readonly' => 'readonly'],
                ]);
        }else{
            echo MaskMoney::widget([
                    'name'    => 'valor1-view' . $pendiente->id,
                    'value'   => $pendiente->precio_neto,
                    'options' => ['readonly' => 'readonly'],
                ]);
        }
        ?>
				</td>

				<td>
					<?php
            if($pendiente->precio_sugerido>0){
                echo MaskMoney::widget([
                    'name'    => 'valor1-view' . $pendiente->id,
                    'value'   => $pendiente->precio_sugerido * $pendiente->cantidad,
                    'options' => ['readonly' => 'readonly'],
                ]);
            }else{
                echo MaskMoney::widget([
                    'name'    => 'valor1-view' . $pendiente->id,
                    'value'   => $pendiente->precio_neto * $pendiente->cantidad,
                    'options' => ['readonly' => 'readonly'],
                ]);
            }
          ?>
				</td>

				<td><?=strtoupper($pendiente->pedido->solicitante)?></td>
        <td>
          <?php if($pendiente->archivo!=''){ ?>
            <a href="http://cvsc.com.co/sgs/web<?=$pendiente->archivo?>" download>
             <i class="fa fa-download" aria-hidden="true"></i>
            </a>
          <?php }else{ 
              echo '-';
              }
          ?>
        </td>

				<td>

				<?php if ($pendiente->pedido->dependencia->estado != 'D'): ?>
				<!-- Llamado ajax para aprobar-->
				<?php Pjax::begin();?>
				  <?=Html::a('Activo', ['pedido/aprobar-producto-activo-especial?id_detalle_producto=' . $pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end();?>


				<?php endif;?>
				</td>

			<td>

				<?php if ($pendiente->pedido->dependencia->estado != 'D'): ?>

				<?php Pjax::begin();?>
				  <?=Html::a('Gasto', ['pedido/aprobar-producto-gasto-especial?id_detalle_producto=' . $pendiente->id], ['class' => 'btn btn-primary']);?>
				<?php Pjax::end();?>


				<?php endif;?>
				</td>

				<td>

				<?php if ($pendiente->pedido->dependencia->estado == 'D'): ?>


					<?php Pjax::begin();?>
					  <?=Html::a('Proyecto', ['pedido/aprobar-producto-proyecto-especial?id_detalle_producto=' . $pendiente->id], ['class' => 'btn btn-primary']);?>
					<?php Pjax::end();?>

				<?php endif;?>

				</td>

<!-- -->
				<td>

				 <?php

echo '
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-rechazo-' . $pendiente->id . '">
                             <i class="fa fa-ban" aria-hidden="true"></i>
                             </button>';

// echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
Modal::begin([

    'header' => '<h4>Motivo Rechazo</h4>',
    'id'     => 'modal-rechazo-' . $pendiente->id,
    'size'   => 'modal-lg',

]);

echo '<input name="itemr-rechazo-' . $pendiente->id . '" id="itemr-rechazo-' . $pendiente->id . '" class="form-control" value="' . $pendiente->id . '"  type="hidden"/>';
echo '<textarea name="mensaje-rechazo-' . $pendiente->id . '" id="mensaje-rechazo-' . $pendiente->id . '" class="form-control" rows="4"></textarea>';
echo '<p>&nbsp;</p>';
echo '<input type="submit" name="rechazar" value="Guardar" class="btn btn-primary btn-lg"/>';
Modal::end();

?>


				</td>


<!-- -->

				<td>

				 <?php

echo '
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-' . $pendiente->id . '">
                             <i class="fa fa-comment-o" aria-hidden="true"></i>
                             </button>';

// echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
Modal::begin([

    'header' => '<h4>Motivo</h4>',
    'id'     => 'modal-' . $pendiente->id,
    'size'   => 'modal-lg',

]);

echo '<input name="item-' . $pendiente->id . '" id="item-' . $pendiente->id . '" class="form-control" value="' . $pendiente->id . '"  type="hidden"/>';
echo '<textarea name="mensaje-' . $pendiente->id . '" id="mensaje-' . $pendiente->id . '" class="form-control" rows="4">' . $pendiente->observacion_financiera . '</textarea>';
echo '<p>&nbsp;</p>';
echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
Modal::end();

?>


				</td>


              </tr>
			<?php

//    var_dump($subtotales);

$sw                  = 0;
$cebe_anterior_copia = $cebe_anterior;

// Calcular subtotal
if ($cebe_anterior == '') {

    $cebe_anterior       = $pendiente->dep;
    $cebe_anterior_copia = $cebe_anterior;
    $sw                  = 0;
    $sw2                 = 0;

} else {

    if ($index + 1 == $limite_subtotales) {

        /* echo 'CeBe Ant: '.$cebe_anterior.'<br>';
        echo 'Dep Aactual: '.$pendiente->dep.'<br>';
        echo 'Copia Cebe: '.$cebe_anterior_copia.'<br>';*/
        $sw                  = 1;
        $cebe_anterior_copia = $pendiente->dep;

        if ($pendiente->dep != $cebe_anterior) {

            $sw2 = 1;
        }

    } else {

        if ($pendiente->dep != $cebe_anterior) {

            $cebe_anterior = $pendiente->dep;
            $sw            = 1;

        } else {

            if ($index + 1 == $limite_subtotales) {

                $sw                  = 1;
                $cebe_anterior_copia = $cebe_anterior;

            }

        }

    }

}

?>


            <?php if ($sw == 1): ?>
			   <tr>

                 <td><?=$cebe_anterior_copia?></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td><strong>Subtotal:</strong></td>
				 <td></td>
				 <td>

				   <?php

echo MaskMoney::widget([

    'name'    => 'valor3-view' . $pendiente->id,
    'value'   => $subtotales[$cebe_anterior_copia],
    'options' => ['readonly' => 'readonly'],
]);

?>

				 </td>

				 <td></td><td></td>
				  <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>


			   </tr>
              <?php $cebe_anterior_copia = $cebe_anterior;?>
            <?php endif;?>

            <?php if ($sw2 == 1): ?>
			   <tr>

                 <td><?=$cebe_anterior?></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td><strong>Subtotal:</strong></td>
				 <td></td>
				 <td>

				   <?php

echo MaskMoney::widget([

    'name'    => 'valor3-view' . $pendiente->id,
    'value'   => $subtotales[$cebe_anterior],
    'options' => ['readonly' => 'readonly'],
]);

?>

				 </td><td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>


			   </tr>

            <?php endif;?>




			  <?php $index++;?>



        	 <?php endforeach;?>

	   </tbody>

	 </table>
 <?php ActiveForm::end();?>
<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>
<table  class="table table-hover" width="100%">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Dependencia</th>
			<th colspan="3">Presupuestos</th>
			<th colspan="2">Pedidos</th>
			<th>Finalizacion</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($model as $key):?>
		<tr>			   
			<td><?= $key['nombre']?></td>
			<td><?= $key['dependencia']?></td>
			<td colspan="3">
			<b>Presupuesto Total:</b><br><?= '$'.number_format($key['presupuesto_total'], 0, '.', '.').' COP';?><br>
			<b>Presupuesto Seguridad:</b><br><?= '$'.number_format($key['presupuesto_seguridad'], 0, '.', '.').' COP';?><br>
			<b>Presupuesto Riesgo:</b><br><?= '$'.number_format($key['presupuesto_riesgo'], 0, '.', '.').' COP';?><br>
			<b>Presupuesto Heas:</b><br><?= '$'.number_format($key['presupuesto_heas'], 0, '.', '.').' COP';?>
			</td>
			<td colspan="2">
			<b>Normales:</b><br><?= $key['normales'];?><br>
			<b>Especiales:</b><br><?= $key['especiales'];?>
			</td>
			<td>
			<?php 
			$date = new DateTime($key['fecha_finalizacion']);
			echo $date->format('Y-m-d');?></td>
			<td>
				<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/update?id='.$key['id'])?>">
					<i class="fa fa-usd"></i>
				</a>
				<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/pedidos-create?id='.$key['id'].'&ceco='.$key['ceco'])?>">
					<i class="fa fa-plus"></i> Pedido Normal
				</a>
				<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/pedidos-create-especial?id='.$key['id'].'&ceco='.$key['ceco'])?>">
					<i class="fa fa-plus"></i> Pedido Especial
				</a>
				<a class="btn btn-primary" href="<?php echo Url::toRoute('proyectos/view?id='.$key['id'])?>">
					<i class="fa fa-list"></i> Ver/Listar
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
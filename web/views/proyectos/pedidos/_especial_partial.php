<?php
use yii\helpers\Url;
?>
<table  class="table table-hover" width="100%">
	<thead>
		<tr>
			<th>Repetido</th>
			<th style="width: 25%;">Material</th>
			<th style="width: 25%;">Cotizacion</th>
			<th>Cantidad</th>
			<th>Solicitante</th>
			<th>Fecha</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($model as $key):?>
		<tr>
			<td>
				<?php
				  if($key['repetido']=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?>
			</td>
			<td><?= $key['material']?></td>
			<td>
				<?php if($key['archivo']!=''){ ?>
					<a href="<?php echo Yii::$app->homeUrl;?><?=$key['archivo']?>" download>
					 <i class="fa fa-download" aria-hidden="true"></i>
					</a>
				<?php }else{ 
						echo '-';
					  }
				?>
			</td>
			<td><?= $key['cantidad']?></td>
			<td><?= $key['solicitante']?></td>
			<td><?= $key['fecha']?></td>
			<td>
				
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
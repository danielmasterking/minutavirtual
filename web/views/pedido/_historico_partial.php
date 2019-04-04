<?php
use yii\bootstrap\Modal;

$roles_usuario = array();
$roles_id = array();
if($usuario != null){
	$roles_usuario = $usuario->roles;
    foreach($roles_usuario as $key){
		$roles_id [] = $key->rol_id;
	}
}
?>
	 <table  class="table table-hover" width="100%">
	 
       <thead>

       <tr>
           <th></th>
           <th>Fecha creación</th>
           <th>Repetido?</th>
		   <th>Dependencia</th>
		   <th>Producto</th>
		   <th>Cantidad</th>           
		   <th>Proveedor</th>
		   <th>Nro Orden de compra</th>
		   <th>Solicitante</th>
		   <th></th>
		   <th>Fecha Rev. Coordinador</th>
		   <th></th>
		   <th>Fecha Rev. Técnica</th>
		   <th></th>
		   <th>Fecha Rev. Financiera</th>
		   <th>Obs Coord</th>
		   <th>Obs Técnica</th>
		   <th>Obs Financiera</th>
		   <th>Mot Rechazo</th>
		   <th></th>
       </tr>
       </thead>
	   <tbody>
		   <?php  foreach($pendientes as $pen):?>
		   <tr>
				<td>
				 <?php
					 if( in_array(1,$roles_id) || in_array(11,$roles_id) ){
                        echo ' 
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-'.$pen['id'].'">
                             <i class="fa fa-pencil" aria-hidden="true"></i>
                             </button>';
                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([
                          'header' => '<h4>Orden de Compra</h4>',
                          'id' => 'modal-'.$pen['id'],
                          'size' => 'modal-lg',
                          ]);
                         echo '<input name="item-'.$pen['id'].'" id="item-'.$pen['id'].'" class="form-control" value="'.$pen['id'].'"  type="hidden"/>';
						 echo '<textarea name="orden-'.$pen['id'].'" id="orden-'.$pen['id'].'" class="form-control" rows="4"></textarea>';
                         echo '<p>&nbsp;</p>';
						 echo '<input type="submit" name="guardar" value="Guardar" class="btn btn-primary btn-lg"/>';
                         Modal::end();
					 }
				 ?>
			</td>
             <td><?=$pen['fecha']?></td>
             <td><?php
				  if($pen['repetido']=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?></td>
			 <td>
			 <?=$pen['dependencia']?></td>
			 <td><?=$pen['producto']?></td>
			 <td><?=$pen['cantidad']?></td>
			 <td><?=$pen['proveedor']?></td>
			 <td><?=$pen['orden']?></td>
			 <td><?=strtoupper($pen['solicitante'])?></td>
			 <td>
			     <?php
					if($pen['estado'] != 'P' && $pen['estado'] != 'E'){
					    if($pen['estado'] == 'R'){
							echo '<i class="fa fa-remove" aria-hidden="true"></i>';
						}else{
                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
						}
					}
				 ?>
			 </td>
			 <td><?= $pen['fcoordinador']?></td>
			 <td>
			     <?php
					if($pen['estado'] != 'R' && $pen['estado'] != 'P' && $pen['estado'] != 'E' && $pen['estado'] != 'T' && $pen['estado'] != 'W'){
					    if($pen['estado'] == 'Y'){
							echo '<i class="fa fa-remove" aria-hidden="true"></i>';
						}else{
                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
						}
					}
				 ?>
			 </td>
			 <td><?= $pen['ftecnica']?></td>
			 <td>
			     <?php
					if($pen['estado'] != 'P' && $pen['estado'] != 'E' && $pen['estado'] != 'T' && $pen['estado'] != 'W'
					   && $pen['estado'] != 'Y' && $pen['estado'] != 'R' && $pen['estado'] != 'F' && $pen['estado'] != 'Z' && $pen['estado'] != 'B'){
						if($pen['estado'] == 'V'){
							echo '<i class="fa fa-remove" aria-hidden="true"></i>';
						}else{
                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
						}
					}
				 ?>
			 </td>
			 <td><?= $pen['ffinanciera'] ?></td>
			 <td><?= $pen['ocoordinador'] ?></td>
			 <td><?= $pen['otecnica'] ?></td>
			 <td><?= $pen['ofinanciera'] ?></td>
			 <td><?= $pen['mrechazo'] ?></td>
			 <td>
			 	<?php 
			 	$permisos = array();
				if( isset(Yii::$app->session['permisos-exito']) ){
					$permisos = Yii::$app->session['permisos-exito'];
				}
			 	if(in_array("administrador", $permisos)){
			 		echo '<button type="button" class="btn btn-primary" onclick="eliminarPedido('.$pen['id'].')">
	                     <i class="fa fa-remove" aria-hidden="true"></i>
	                     </button>';
                 }
			 	?>
			 </td>
           </tr>
           <?php endforeach;?>
	   </tbody>
	 </table>
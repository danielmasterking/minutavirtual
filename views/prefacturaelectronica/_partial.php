<?php
use yii\helpers\Url;

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
       			<th style="text-align: center;">Ver</th>
       			<th style="text-align: center;">Numero Factura</th>
       			<th style="text-align: center;">Fecha Factura</th>
       			<th style="text-align: center;">Nombre factura</th>
	           	<th style="text-align: center;">Fecha creación</th>
	           	<th style="text-align: center;">Mes</th>
			   	<th style="text-align: center;">Año</th>
			   	<th style="text-align: center;">Usuario</th>
			   	<th style="text-align: center;">Regional</th>
			   	<th style="text-align: center;">Ceco</th>
			   	<th style="text-align: center;">Dependencia</th>           
			   	<th style="text-align: center;">Empresa</th>
			   	<th style="text-align: center;">Cuenta contable</th>
			   	<th style="text-align: center;">$ Dispositivos fijos</th>
			   	<th style="text-align: center;">$ Dispositivos variables</th>
			   	<th style="text-align: center;">$ Monitoreo</th>
			   	<th style="text-align: center;">$ Total</th>
			   
			   	<th></th>
       		</tr>
       	</thead>
	   	<tbody>
		   	<?php  
		   		$contador=0;
		   		foreach($prefacturas as $pref):
		   	?>
		   	<tr style="text-align: center;">
		   		<td>
		   			<?php if($pref['estado']=='abierto'){?>
			   		<a href="<?php echo Url::toRoute('prefacturaelectronica/view?id='.$pref['id'])?>" class="btn btn-primary btn-xs">
				        <i class="fa fa-folder-open-o"></i> Abrir
				    </a>

				    <a href="<?php echo Url::toRoute('prefacturaelectronica/imprimir?id='.$pref['id'])?>" class="btn btn-danger btn-xs" target="_blank">
					    <i class="fa fa-file-pdf-o"></i> Imprimir
					</a>
				    <?php }?>
				    <?php if($pref['estado']=='cerrado'){?>
					    <a href="<?php echo Url::toRoute('prefacturaelectronica/imprimir?id='.$pref['id'])?>" class="btn btn-danger btn-xs" target="_blank">
					        <i class="fa fa-file-pdf-o"></i> Imprimir
					    </a>
				    <?php }?>
			    </td>

			    <td><?=$pref['numero_factura']?></td>
			    <td><?=$pref['fecha_factura']?></td>
			    <td>
			    	<?php

			    		echo $pref['nombre_factura']==''?'No aplica':$pref['nombre_factura'];
			    	?>
			    	
			    </td>
			    
         		<td><?=$pref['fecha']?></td>
		 		<td><?=$pref['mes']?></td>
		 		<td><?=$pref['ano']?></td>
		 		<td><?=$pref['usuario']?></td>
		 		<td><?=$pref['regional']?></td>
		 		<td><?=$pref['ceco']?></td>
		 		<td><?=$pref['dependencia']?></td>
		 		<td><?php echo $pref['empresa']?></td> 
		 		<td>523595006</td>
		 		<td>
		 			<?php 
		 				
		 				echo '$ '.number_format($pref['fijos'], 0, '.', '.').' COP' ;
		 			?>
		 			
		 		</td>
		 		<td>
		 			<?php 
		 				
		 				echo '$ '.number_format($pref['variables'], 0, '.', '.').' COP' ;
		 			?>
		 			
		 		</td>
		 		<td>
		 			<?php 
		 				
		 				echo '$ '.number_format($pref['Monitoreo'], 0, '.', '.').' COP';
		 			?>
		 			
		 		</td>
		 		<td>
		 			
		 			<?php 
		 			$tot=($pref['Total']+$pref['Monitoreo']);

		 			echo '$ '.number_format($tot, 0, '.', '.').' COP';
		 			?>
		 		</td> 
		 		
			 	<td>

			 		<?php 
			 		$permisos = array();
					if( isset(Yii::$app->session['permisos-exito']) ){
						$permisos = Yii::$app->session['permisos-exito'];
					}
				 	//if(in_array("administrador", $permisos)){
						// if($pref['estado']=='abierto' and $pref['usuario']==Yii::$app->session['usuario-exito']){
					 // 		echo '<button type="button" class="btn btn-primary btn-xs" onclick="eliminar('.$pref['id'].')">
			   //                   <i class="fa fa-remove" aria-hidden="true"></i>
			   //                   </button>';
			   //          }else{

			            	if(in_array("administrador", $permisos)){
			            		echo '<button type="button" class="btn btn-primary btn-xs" onclick="eliminar('.$pref['id'].')">
			                     <i class="fa fa-remove" aria-hidden="true"></i>
			                     </button>';
			            	}elseif($pref['estado']=='abierto' and $pref['usuario']==Yii::$app->session['usuario-exito'] and !in_array("prefactura-regional", $permisos)){
			            		echo '<button type="button" class="btn btn-primary btn-xs" onclick="eliminar('.$pref['id'].')">
			                     <i class="fa fa-remove" aria-hidden="true"></i>
			                     </button>';
			            	}

			            //}
	                 //}
			 		?>
			 	</td>
           	</tr>
           <?php 
           	$contador++;
           	endforeach;
           ?>

           <?php if($contador==0): ?>
           	<tr>
           		<td colspan="20">
           			<i class="fa fa-frown-o" aria-hidden="true"></i> No se encontro ningun resultado
           		</td>
           	</tr>
           <?php endif;?>
	   	</tbody>
 	</table>
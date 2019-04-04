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
	           	<th style="text-align: center;">Fecha creación</th>
	           	<th style="text-align: center;">Mes</th>
			   	<th style="text-align: center;">Año</th>
			   	<th style="text-align: center;">Usuario</th>
			   	<th style="text-align: center;">Dependencia</th>           
			   	<th style="text-align: center;">Empresa</th>
			   	<th style="text-align: center;">Total de FTES</th>
			   	<th style="text-align: center;">Total del Servicio</th>
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
			   		<a href="<?php echo Url::toRoute('prefactura-fija/view?id='.$pref['id'])?>" class="btn btn-primary btn-xs">
				        <i class="fa fa-folder-open-o"></i> Abrir
				    </a>

				    <a href="<?php echo Url::toRoute('prefactura-fija/imprimir?id='.$pref['id'])?>" class="btn btn-danger btn-xs" target="_blank">
					    <i class="fa fa-file-pdf-o"></i> Imprimir
					</a>
				    <?php }?>
				    <?php if($pref['estado']=='cerrado'){?>
					    <a href="<?php echo Url::toRoute('prefactura-fija/imprimir?id='.$pref['id'])?>" class="btn btn-danger btn-xs" target="_blank">
					        <i class="fa fa-file-pdf-o"></i> Imprimir
					    </a>
				    <?php }?>
			    </td>
			    <?php 
			    	//AQUI SE CALCULA EL VALOR TOTAL DE FTES Y EL VALOR TOTAL DEL SERVICIO
			    	$dispositivos = $model_dispositivo->find()->where('id_prefactura_fija='.$pref['id'])->all();
			    	$total_ftes_fijos = 0;
			    	$total_ftes_variable = 0;
			    	$total_servicio_fijo = 0;
			    	$total_servicio_variable = 0;
			    	foreach ($dispositivos as $value) {
			    		if($value->tipo=='fijo'){
			    			$total_ftes_fijos = $total_ftes_fijos + $value->ftes;
			    			$total_servicio_fijo = $total_servicio_fijo + $value->valor_mes;
			    		}elseif($value->tipo=='variable'){
			    			if($value->tipo_servicio !='No Prestado'){

                               $total_ftes_variable = $total_ftes_variable + $value->ftes;
                               $total_servicio_variable = $total_servicio_variable + $value->valor_mes;

                            }else{

                               $total_ftes_variable = $total_ftes_variable - $value->ftes;
                               $total_servicio_variable = $total_servicio_variable - $value->valor_mes;
                               
                            }
			    		}

			    	}

			    ?>
         		<td><?=$pref['fecha']?></td>
		 		<td><?=$pref['mes']?></td>
		 		<td><?=$pref['ano']?></td>
		 		<td><?=$pref['usuario']?></td>
		 		<td><?=$pref['dependencia']?></td>
		 		<td><?=$pref['empresa']?></td>
		 		<td><?=($total_ftes_fijos+$total_ftes_variable)?></td>
		 		<td><?='$ '.number_format(($total_servicio_fijo+$total_servicio_variable), 0, '.', '.').' COP'?></td>
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
			            	}elseif($pref['estado']=='abierto' and $pref['usuario']==Yii::$app->session['usuario-exito']){
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
<?php
use yii\bootstrap\Modal;
?>
	 <table class="table table-hover" width="100%">
       <thead>
       <tr>
		   <th>F.Creación</th>
		   <th>Rptdo?</th>
		   <th>Dependencia</th>
		   <th>CeBe</th>
           <th>Producto</th>
           <th>Prod. Sugerido</th>
		   <th>Cant.</th>
		   <th>Proveedor</th>
		   <th>Orden Compra</th>
		   <th>Código Activo</th>
		   <th>Precio Neto(UN)</th>
		   <th>Precio Total</th>
		   <th>Revision Financiera</th>
		   <th>Fecha Rev. Finan</th>
		   <th>Obs. Finan</th>
		   <th>Motivo Rechazo</th>
       </tr>
       </thead>	 
	   <tbody>
             <?php foreach($pendientes as $pendiente):?>
              <tr>			   
                <td><?= $pendiente['fecha']?></td>
                <td>
				<?php
				  if($pendiente['repetido']=='SI'){
					  echo '<label style="color: red;">R</label>';
				  }
				?>
				</td>
				<td><?= $pendiente['dependencia']?></td>
					
                <td><?= $pendiente['cebe']?></td>
                <td><?= $pendiente['producto']?></td>
				<td><?= $pendiente['producto_sugerido']?></td>
                <td><?= $pendiente['cantidad']?></td>				
				<td><?= $pendiente['proveedor']?></td>

     			<td><?= $pendiente['orden']?></td>
     			<td><?= $pendiente['codigo_activo']?></td>
				<td>
				<?php 
					echo '$'.number_format($pendiente['precio_sugerido'], 0, '.', '.');
				?>
				</td>
                <td>
                <?php 
                	echo '$'.number_format($pendiente['precio_total'], 0, '.', '.');
                ?>
                </td>
                <td>
				    <?php
					    if($pendiente['estado'] == 'Z' || $pendiente['estado'] == 'C' || $pendiente['estado'] == 'O' || $pendiente['estado'] == 'I'){
					    	echo '<i class="fa fa-check" aria-hidden="true"></i>';
						} else if($pendiente['estado'] == 'V'){
                          	echo 'Rechazado';
						} else {
                          	echo '<i class="fa fa-remove" aria-hidden="true"></i>';
						}
					?>
				</td>
				<td><?= $pendiente['ffinanciera']?></td>
				<td><?= $pendiente['ofinanciera']?></td>
				<td><?= $pendiente['mrechazo']?></td>
              </tr>
        	 <?php endforeach; ?>
	   </tbody>
	 </table>
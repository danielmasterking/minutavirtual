<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



/*Server bluehost*/
$logo = '/home/cvsccomc/public_html/sgs/web/img/EXITOPORTADA.png';
$prefijo = '/home/cvsccomc/public_html/sgs/web';

/*Servidor Local*/
//$logo = '/exito/web/img/EXITOPORTADA.png';
//$prefijo = '/exito/web';



$title = 'Incidente ';
$fotos = $model->fotosIncidente;


?>

<div class="container" style="margin-top:5px;padding-top:5px;">

<div class="row">



<div class="rol-index col-md-12">
  

 <div class="col-md-12">
 
<img src="<?php echo $logo; ?>">  

	 <h1 style="text-align: center;"><?php echo $title; ?></h1>
	 	
		<p>&nbsp;</p>
				

	 
	  <div >
	  <p>&nbsp;</p>
	   <div>
	     <label><strong>Fecha:</strong> <?php echo $model->fecha;?></label>
		 
	   </div>
	   	    <p>&nbsp;</p>
		<div>
	     
		 <label><strong>Dependencia:</strong> <?php echo $model->dependencia->nombre;?></label>
	     
	   </div>

	   <p>&nbsp;</p>

	   <div >
	     
		 <label><strong>Tipo de incidente:</strong> <?php echo $model->novedad->nombre;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
		
	   <div>
	   
	   <table>
	      
		  <thead>
		  
		     <tr>
			 
			   <th>Detalle</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>&nbsp;</th>
			   <th>Fotografía</th>
			 
			 </tr>
		  
		  </thead>
		  
		  <tbody>
		  
		    <tr>
			
			   <td><?php echo $model->detalle;?></td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td>&nbsp;</td>
			   <td><img src="<?php echo $prefijo.$model->imagen;?>" /> </td>
			
			</tr>
		  
		  </tbody>
	   
	   </table>
	   
	   
	    </div>
	   
	     
	   <p>&nbsp;</p>
	   <div>
	   <label><strong>Recomendaciones</strong></label>
	   
	   <p><?php echo $model->recomendaciones;?></p>
	   
	    </div>
	   
	
	   <pagebreak />
	   <div >
	   	 <h4 style="text-align: center;"><strong>Registro Fotografico</strong></h4>  
		    <p>&nbsp;</p>
	     <?php
		 
		 if($fotos != null){
			 
			 foreach($fotos as $key){
				 
				 ?>
				 
				 	     <?php
		 
					 /**********************Rendering Image *******************************/
					  if($key->imagen != null && $key->imagen != ''){
						  
						  /**Validar imagen o pdf o xls*/
						 if((strpos($key->imagen, 'pdf') === false && strpos($key->imagen, 'docx') === false && strpos($key->imagen, 'xlsx') === false ) ){
							  
						  
						  ?>
						  <h4 style="text-align: center;"><strong>Investigaciones Anteriores</strong></h4>
						  <p>&nbsp;</p>
						   <img src="<?php echo $prefijo.$key->imagen; ?>">  
						  
						  <?php
						  }			  
						  ?>
						  
						  
						  
						  <?php
						  
					  }
						  
						  
					 ?>

				    <p>&nbsp;</p>
				 <?php
				 
			 }
			 
		 }
		 	  
		  ?>

	   
	   </div>
	   
	   <p>&nbsp;</p>
	    

	  </div>

 </div>
  
</div>
</div>
</div>

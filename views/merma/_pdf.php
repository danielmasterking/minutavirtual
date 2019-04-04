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



$title = 'Siniestro ';
$fotos = $model->fotosSiniestro;


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
	     <label><strong>Fecha de creación:</strong> <?php echo $model->fecha;?></label>
		 
	   </div>
	   	    <p>&nbsp;</p>
		<div>
	     
		 <label><strong>Dependencia:</strong> <?php echo $model->dependencia->nombre;?></label>
	     
	   </div>

	   <p>&nbsp;</p>

	   <div >
	     
		 <label><strong>Tipo de siniestro:</strong> <?php echo $model->novedad->nombre;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
		<div>
	     
		 <label><strong>Área:</strong> <?php echo $model->areaDependencia->nombre;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
		<div>
	     
		 <label><strong>Zona:</strong> <?php echo $model->zonaDependencia->nombre;?></label>
	     
	   </div>
	   

	    <p>&nbsp;</p>		
	   <div>
	   <label><strong>Resumen de los hechos</strong></label>
	   
	   <p><?php echo $model->resumen;?></p>
	   
	    </div>
	   
	   <p>&nbsp;</p>
	   	   <div>
	   <label><strong>Observaciones</strong></label>
	   
	   <p><?php echo $model->observacion;?></p>
	   
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
				 <img src="<?php echo $prefijo.$key->imagen; ?>">  
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

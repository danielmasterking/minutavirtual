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



$title = 'Visita Quincenal ';
$detalle_visita = $model->detalle; //array con detalle de la visita
$seguridad_electronica = false;


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

	   <div >
	     
		 <label><strong>Dependencia:</strong> <?php echo $model->dependencia->nombre;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
	     
		<div >
	     
		 <label><strong>Atendió visita:</strong> <?php echo $model->responsable;?></label>
	     
	   </div>
	   	    <p>&nbsp;</p>
	   	<div>
	     
		 <label><strong>Otro:</strong> <?php echo $model->otro;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
	    
	   <div>
	   <label><strong>Observaciones</strong></label>
	   
	   <p><?php echo $model->observaciones;?></p>
	   
	    </div>
	
	   
    <p>&nbsp;</p>
	<h3 style="text-align: center;">Detalle visita</h3>
   
   <?php foreach($detalle_visita as $detalle){?>
		  
	  <?php if($detalle->novedad->id != 10){?>  
	  
		 <div>
			<p>&nbsp;</p>
			 <p>
			 
			 <strong><?php echo $detalle->novedad->id;?></strong>
			 <?php echo '. '.$detalle->novedad->nombre.' &nbsp;&nbsp;<strong>'.$detalle->resultado->nombre.'</strong> &nbsp;&nbsp;'.$detalle->mensajeNovedad->mensaje;?>
			 
			 
			 </p>
			  <p><strong>Observación: </strong><?php echo $detalle->observacion;?></p>
			
		 </div>	  
   
   
	  <?php }else{ ?>
	
	             <?php if($seguridad_electronica === false){ ?>
				 
					 <div>
						<p>&nbsp;</p>
						 <p>
						 
						 <strong><?php echo $detalle->novedad->id;?></strong>
						 <?php echo '. '.$detalle->novedad->nombre;?>
						 
						 
						 </p>
						
					 </div>	  
					 <!-- Sección -->
					 <div>
						<p>&nbsp;</p>
						 <p>
						 
						 <strong>* Sección</strong>
						 <?php echo ' '.$detalle->seccion->seccion->nombre.' &nbsp;&nbsp;<strong>'.$detalle->resultado->nombre.'</strong> &nbsp;&nbsp;'.$detalle->mensajeNovedad->mensaje;?>
						 
						 
						 </p>
						 <p><strong>Observación: </strong><?php echo $detalle->observacion;?></p>
						
					 </div>	 					 
				 
				 
				    <?php $seguridad_electronica = true; ?>
     			<?php }else{ ?>
				
				  <!-- Sección -->
					 <div>
						
						<p>&nbsp;</p>
						 <p>
						 
						 <strong>* Sección</strong>
						 <?php echo ' '.$detalle->seccion->seccion->nombre.' &nbsp;&nbsp;<strong>'.$detalle->resultado->nombre.'</strong> &nbsp;&nbsp;'.$detalle->mensajeNovedad->mensaje;?>
						 
						 
						 </p>
						 <p><strong>Observación: </strong><?php echo $detalle->observacion;?></p>
						
					 </div>	 
				
                       
					   
		         <?php } ?>
		   <?php } ?>	
   <?php } ?>
		   
<pagebreak />
	   <div >
	   	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->foto != null && $model->foto != ''){
			  
			  ?>
			  <h4 style="text-align: center;"><strong>Registro Fotografico</strong></h4>
			  <img src="<?php echo $prefijo.$model->foto; ?>">  
			  
			  <?php
			  
		  }
		  
		  ?>

	   
	   </div>
  

	  </div>

 </div>
  
</div>
</div>
</div>

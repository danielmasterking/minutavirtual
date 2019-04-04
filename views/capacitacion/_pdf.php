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



$title = 'Capacitación ';

$capacitacion_instructores = $model->capacitacionInstructor;

$instructores = array();


foreach($capacitacion_instructores as $key){
	
	$instructores [] = $key->instructor;
	
}

$capacitacionDependencias = $model->capacitacionDependencias;
$dependencias = array();

if($capacitacionDependencias != null){
	
	foreach($capacitacionDependencias as $key){
		
		$dependencias [] = array('nombre' => $key->dependencia->nombre, 'cantidad' => $key->cantidad);
		
	}
	
}

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
	     
		 <label><strong>Fecha de capacitación:</strong> <?php echo $model->fecha_capacitacion;?></label>
		 
	     
	   </div>
	   
	   	<p>&nbsp;</p>
		<div>
	     <label><strong>Creada por:</strong> <?php echo $model->usuario;?></label>
	     
	   </div>
	   <p>&nbsp;</p>
	   <div>
	     
		 <label><strong>Instructor:</strong> <?php echo $instructores[0];?></label>
	     
	   </div>
	   <p>&nbsp;</p>
	   <div >
	     
		 <label><strong>Tema:</strong> <?php echo $model->novedad->nombre;?></label>
	     
	   </div>
	    <p>&nbsp;</p>
	   <div>
	   <label><strong>Observaciones</strong></label>
	   
	   <p><?php echo $model->observaciones;?></p>
	   
	    </div>
		<p>&nbsp;</p>
       <div>
	   <label><strong>Lugar(es)</strong></label>
	   
          <table>
	         
			 <thead>
			    
				<tr>
				  
				  <td>Nombre</td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td>Cantidad</td>
				
				</tr>
			 
			 </thead>
			 
			 <tbody>
			 
			  <?php if($dependencias != null):?>
				<?php foreach($dependencias as $key):?>
				
				   <tr>
				   
				     <td><?=$key['nombre']?></td>
					  <td></td>
					  <td></td>
					  <td></td>					 
					 <td><?=$key['cantidad']?></td>
				   
				   </tr>
				    
				<?php endforeach;?>
			  <?php endif;?>
			    

			 </tbody>
			 
           </table>
	   
	    </div>
	   
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
	   
	   <p>&nbsp;</p>
	   <div>
	   
	   
	     <?php
		 
		 /**********************Rendering Image *******************************/
		  if($model->lista != null && $model->lista != ''){
			  
			  /**Validar imagen o pdf o xls*/
			 if((strpos($model->lista, 'pdf') === false && strpos($model->lista, 'xls') === false && strpos($model->lista, 'xlsx') === false ) ){
				  
			  
			  ?>
			  <h4 style="text-align: center;"><strong>Acta de asistencia</strong></h4>
			  <p>&nbsp;</p>
			   <img src="<?php echo $prefijo.$model->lista; ?>">  
			  
			  <?php
			  }			  
			  ?>
			  
			  
			  
			  <?php
			  
		  }
			  
			  
		 ?>
		    
				   
	   </div>	   

	  </div>

 </div>
  
</div>
</div>
</div>

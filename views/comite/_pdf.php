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
$ComiteDependencias = $model->dependencias;
$ComiteMarcas = $model->distritos;
$ComiteCordinadores = $model->cordinadores;
$dependencias = array();
$marcas = array();
$cordinadores = array();
if($ComiteDependencias != null){
	
	foreach($ComiteDependencias as $key){
		
		$dependencias [] = array('nombre' => $key->dependencia->nombre);
		
	}
	
}

if($ComiteMarcas != null){
	
	foreach($ComiteMarcas as $key){
		
		$marcas [] = array('nombre' => $key->distrito->nombre);
		
	}
	
}

if($ComiteCordinadores != null){
	
	foreach($ComiteCordinadores as $key){
		
		$cordinadores [] = array('nombre' => $key->usuario0->nombres.' '.$key->usuario0->apellidos);
		
	}
	
}

$title = 'Comité ';


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
	     <label><strong>Creado por:</strong> <?php echo $model->usuario;?></label>
	     
	   </div>
	   <p>&nbsp;</p>

	   <div >
	     
		 <label><strong>Tipo de comité:</strong> <?php echo $model->novedad->nombre;?></label>
	     
	   </div>
	   	   <p>&nbsp;</p>
	   	<?php if($dependencias != null):?>
	   <div class="col-md-12">
	   
	   
	       <table class="table">
	         
			 <thead>
			    
				<tr>
				  
				  <th><label><strong>Lugar:</strong></label></th>

				
				</tr>
			 
			 </thead>
			 
			 <tbody>
			 

				<?php foreach($dependencias as $key):?>
				
				   <tr>
				   
				     <td><?=$key['nombre']?></td>
				   
				   </tr>
				    
				<?php endforeach;?>

			    

			 </tbody>
			 
           </table>
			
			
	   
	   </div>
	   <?php endif;?>
	  <?php if($marcas != null):?>
	   <div class="col-md-12">
	   
	   
	       <table class="table">
	         
			 <thead>
			    
				<tr>
				  
				  <th><label><strong>Distrito:</strong></label></th>

				
				</tr>
			 
			 </thead>
			 
			 <tbody>
			 

				<?php foreach($marcas as $key):?>
				
				   <tr>
				   
				     <td><?=$key['nombre']?></td>
				   
				   </tr>
				    
				<?php endforeach;?>

			    

			 </tbody>
			 
           </table>
			
			
	   
	   </div>
	   <?php endif;?>
	   	  <?php if($cordinadores != null):?>
	   <div class="col-md-12">
	   
	   
	       <table class="table">
	         
			 <thead>
			    
				<tr>
				  
				  <th><label><strong>Cordinador:</strong></label></th>

				
				</tr>
			 
			 </thead>
			 
			 <tbody>
			 

				<?php foreach($cordinadores as $key):?>
				
				   <tr>
				   
				     <td><?=$key['nombre']?></td>
				   
				   </tr>
				    
				<?php endforeach;?>

			    

			 </tbody>
			 
           </table>
			
			
	   
	   </div>
	   <?php endif;?>	   
			    
	    <p>&nbsp;</p>
	   <div>
	   <label><strong>Observaciones</strong></label>
	   
	   <p><?php echo $model->observaciones;?></p>
	   
	    </div>
	   
	   <p>&nbsp;</p>
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

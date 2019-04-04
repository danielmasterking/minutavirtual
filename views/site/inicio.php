<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\services\GeocodingClient;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use yii\helpers\VarDumper;


//Imagenes de marcadores 
$marcadores = array();
$marcadores[0] = Yii::$app->request->baseUrl.'/img/exito.png';
$marcadores[1] = Yii::$app->request->baseUrl.'/img/carulla.png';
$marcadores[2] = Yii::$app->request->baseUrl.'/img/surtimax.png';
$marcadores[3] = Yii::$app->request->baseUrl.'/img/otros.png';

//
$ciudades_zonas = array();

foreach($zonasUsuario as $zona){
	
     $ciudades_zonas [] = $zona->zona->ciudades;	
	
}

$ciudades_permitidas = array();

foreach($ciudades_zonas as $ciudades){
	
	foreach($ciudades as $ciudad){
		
		$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
		
	}
	
}

$marcas_permitidas = array();

foreach($marcasUsuario as $marca){
	
		
		$marcas_permitidas [] = $marca->marca_id;

}

$dependencias_distritos = array();

foreach($distritosUsuario as $distrito){
	
     $dependencias_distritos [] = $distrito->distrito->dependencias;	
	
}

$dependencias_permitidas = array();

foreach($dependencias_distritos as $dependencias0){
	
	foreach($dependencias0 as $dependencia0){
		
		$dependencias_permitidas [] = $dependencia0->dependencia->codigo;
		
	}
	
}

$tamano_dependencias_permitidas = count($dependencias_permitidas);

$puestos_permitidos = array();

foreach($puestos as $puesto){
	
	if(in_array($puesto->ciudad_codigo_dane,$ciudades_permitidas) ){
		
		if(in_array($puesto->marca_id,$marcas_permitidas) ){
			
			$puestos_permitidos [] = $puesto;
			
			//TO-DO Validación de distritos
			
		}
		
	}
	
}

$puestos = $puestos_permitidos;





$this->title = 'Grupo Exito';
?>
<?php
    
	$geocodingClient = new GeocodingClient();
    
	$coord = new LatLng(['lat' => 4.160477496340009, 'lng' => -72.93036425000003]);
    
  
	   $map = new Map([
          'center' => $coord,
          'zoom' => 5,
      ]); 

	  $map->width = "100%";
      $map->height = 700;
      // Append its resulting script
      

      // Display the map -finally :)
      
	  $contador = 0;
	  $otro = array();
	  foreach($puestos as $puesto){
		  
		  $answer = null;
		  
		  
		 if($puesto->direccion != 'NO' && $puesto->direccion != 'NO ES DEPENDENCIA'){
			$answer = $geocodingClient->lookup(['address' => $puesto->direccion.','.$puesto->ciudad->nombre.',Colombia ']);    
		 }else{
			 $contador++;
		 }
		  
           //var_dump($answer);
			if($answer != null){
				
						if(array_key_exists('results', $answer)){
						  
							if(array_key_exists(0, $answer['results'])){
							  
							  $lat = $answer['results'][0]['geometry']['location']['lat'];
							  $lon = $answer['results'][0]['geometry']['location']['lng'];

							  $coord = new LatLng(['lat' =>  $lat, 'lng' => $lon]);
							  
							  //$otro [] = $coord;
							  //var_dump($answer['results'][0]['geometry']['location']);

							}

							  
						  }else{
							  
							  $contador++;
							 
							 $answer = $geocodingClient->lookup(['address' => 'Colombia']);   
                            //  $answer = $geocodingClient->lookup(['address' => $puesto->direccion.' '.$puesto->ciudad->nombre.' Colombia ']);   
							  if(array_key_exists(0, $answer['results'])){
								
								$lat = $answer['results'][0]['geometry']['location']['lat'];
								$lon = $answer['results'][0]['geometry']['location']['lng'];

								$coord = new LatLng(['lat' =>  $lat, 'lng' => $lon]);
								

							  }

						  }		
						  
						  
						  
						  $img_marcador = '';
						  
						  if(strpos($puesto->marca->nombre,'EXITO') !== false){
							  
							 $img_marcador = $marcadores[0];
							 
						  }elseif(strpos($puesto->marca->nombre,'CARULLA') !== false){
							  
							 $img_marcador = $marcadores[1];
							 
						  }elseif(strpos($puesto->marca->nombre,'SURTIMAX') !== false){
							 
							 $img_marcador = $marcadores[2];				 
						  }else{
							  
							  $img_marcador = $marcadores[3];				 
							  
						  }

						// Lets add a marker now
							  $marker = new Marker([
								  'position' => $coord,
								  'icon' => $img_marcador,
								  'title' => $puesto->nombre,
							  ]);

							  // Provide a shared InfoWindow to the marker
							  $marker->attachInfoWindow(
								  new InfoWindow([
									  'content' => '<div>
									                 <p><strong>'.$puesto->nombre.' '.$puesto->ciudad->nombre.'</strong></p>
										
													 <p>'.$puesto->direccion.'</p>'.
													 Html::a('<i class="fa fa-eye fa-fw"></i>',Yii::$app->request->baseUrl.'/centro-costo/informacion?id='.$puesto->codigo).'
													</div>'
								  ])
							  );

							  // Add marker to the map
							  $map->addOverlay($marker);	
				
			}else{
				
				
			}		   
 
	  }
	  
	//  var_dump($contador);
	  
      echo $map->display(); 	  



?>
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


$this->title = 'Grupo Exito';
?>

<div class="col-md-12">

<!-- Mapa -->

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
      
	  
	  foreach($puestos as $puesto){
		  
		  $answer = $geocodingClient->lookup(['address' => $puesto->direccion.' '.$puesto->ciudad->nombre]);   
		  			
			if(array_key_exists('results', $answer)){
			  
				if(array_key_exists(0, $answer['results'])){
				  
				  $lat = $answer['results'][0]['geometry']['location']['lat'];
				  $lon = $answer['results'][0]['geometry']['location']['lng'];

				  $coord = new LatLng(['lat' =>  $lat, 'lng' => $lon]);
				  //var_dump($answer['results'][0]['geometry']['location']);

				}

				  
			  }else{
				 
				 $answer = $geocodingClient->lookup(['address' => 'Colombia']);   

				  if(array_key_exists(0, $answer['results'])){
					
					$lat = $answer['results'][0]['geometry']['location']['lat'];
					$lon = $answer['results'][0]['geometry']['location']['lng'];

					$coord = new LatLng(['lat' =>  $lat, 'lng' => $lon]);
					

				  }

			  }		

			// Lets add a marker now
				  $marker = new Marker([
					  'position' => $coord,
					  'title' => $puesto->nombre,
				  ]);

				  // Provide a shared InfoWindow to the marker
				  $marker->attachInfoWindow(
					  new InfoWindow([
						  'content' => '<p><strong></strong>'.$puesto->nombre.' '.$puesto->ciudad->nombre.'</p>'
					  ])
				  );

				  // Add marker to the map
				  $map->addOverlay($marker);
			  
		  
	  }
	  
      echo $map->display(); 	  



?>

</div>
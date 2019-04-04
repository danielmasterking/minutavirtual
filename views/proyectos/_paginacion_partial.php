
<?php 
/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
//funciona la paginacion con numeros impares para que quede el del medio senalado.
$numeroBotones=5;
$botonSenalado=($numeroBotones-1)/2;
if ($cur_page >= $numeroBotones) {
	$start_loop = $cur_page - $botonSenalado;
	if ($no_of_paginations > $cur_page + $botonSenalado)
		$end_loop = $cur_page + $botonSenalado;
	else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - ($numeroBotones-1)) {
		$start_loop = $no_of_paginations - ($numeroBotones-1);
		$end_loop = $no_of_paginations;
	} else {
		$end_loop = $no_of_paginations;
	}
} else {
	$start_loop = 1;
	if ($no_of_paginations > $numeroBotones)
		$end_loop = $numeroBotones;
	else
		$end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg = "<div>";
$msg .= "<ul class='pagination'>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
	$msg .= "<li p='1'><a href='#' onclick='return false;'>Primero</a></li>";
} else if ($first_btn) {
	$msg .= "<li p='1' class='disabled'><a href='#' onclick='return false;'>Primero</a></li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
	$pre = $cur_page - 1;
	$msg .= "<li p='$pre'><a href='#' onclick='return false;'>Anterior</a></li>";
} else if ($previous_btn) {
	$msg .= "<li class='disabled'><a href='#' onclick='return false;'>Anterior</a></li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

	if ($cur_page == $i)
		$msg .= "<li p='$i' class='active'><a href='#' onclick='return false;'>{$i}</a></li>";
	else
		$msg .= "<li p='$i'><a href='#' onclick='return false;'>{$i}</a></li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
	$nex = $cur_page + 1;
	$msg .= "<li p='$nex'><a href='#' onclick='return false;'>Siguiente</a></li>";
} else if ($next_btn) {
	$msg .= "<li class='disabled'><a href='#' onclick='return false;'>Siguiente</a></li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
	$msg .= "<li p='$no_of_paginations'><a href='#' onclick='return false;'>Ultimo</a></li>";
} else if ($last_btn) {
	$msg .= "<li p='$no_of_paginations' class='disabled'><a href='#' onclick='return false;'>Ultimo</a></li>";
}

$msg = $msg . "</ul>";  // Content for pagination
$msg .= "</div>";
echo $msg;
?>
<?php echo $total_string = "<span class='total' a='$no_of_paginations'>Pagina <b>$cur_page</b> de <b>$no_of_paginations</b> de <b>$modelcount</b></span>";?>

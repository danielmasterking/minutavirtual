<?php 
$data_productos=array();
foreach ($productos as $value) {
    $data_productos [] = array('codigo' => $value->id, 'cod_material' => $value->material, 'nombre' => $value->material.'-'.$value->texto_breve, 'precio' => $value->precio);
}
echo json_encode($data_productos);
?>
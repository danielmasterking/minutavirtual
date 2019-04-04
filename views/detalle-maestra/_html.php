<?php 
$data_productos=array();
foreach ($productos as $value) {
    $data_productos [] = array('codigo' => $value->id, 'cod_material' => $value->material, 'nombre' => $value->material.'-'.$value->texto_breve, 'proveedor' => $value->maestra->proveedor->nombre, 'precio' => $value->precio_neto);
}
echo json_encode($data_productos);
?>
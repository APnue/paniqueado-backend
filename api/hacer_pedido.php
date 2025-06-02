<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$id_usuario = intval($data['id_usuario']);
$total = floatval($data['total']);
$productos = $data['productos'];

// Insertar en pedidos
$sql_pedido = "INSERT INTO pedidos (id_usuario, total) VALUES ($id_usuario, $total)";
if ($conexion->query($sql_pedido) === TRUE) {
  $id_pedido = $conexion->insert_id;

  foreach ($productos as $prod) {
    $id_producto = intval($prod['id']);
    $cantidad = intval($prod['cantidad']);
    $subtotal = floatval($prod['subtotal']);

    $conexion->query("INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, subtotal) VALUES ($id_pedido, $id_producto, $cantidad, $subtotal)");
  }

  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $conexion->error]);
}

$conexion->close();
?>

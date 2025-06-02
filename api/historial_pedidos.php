<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connection.php';

$id_usuario = intval($_GET['id'] ?? 0);

$sql = "SELECT id, fecha, total, estado FROM pedidos WHERE id_usuario = $id_usuario ORDER BY fecha DESC";
$result = $conexion->query($sql);

$pedidos = [];

while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
$conexion->close();
?>

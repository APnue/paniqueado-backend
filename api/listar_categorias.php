<?php
// Permitir que cualquier origen haga peticiones a esta API
header('Access-Control-Allow-Origin: *');
// Permitir varios métodos HTTP
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
// Permitir ciertos encabezados
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Si es una petición OPTIONS (preflight), responder OK y salir
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connection.php';

$sql = "SELECT * FROM categorias";
$result = $conexion->query($sql);
$categorias = [];

while ($row = $result->fetch_assoc()) {
  $categorias[] = $row;
}

echo json_encode($categorias);
$conexion->close();
?>
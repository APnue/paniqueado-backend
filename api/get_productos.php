<?php
// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS (aunque aquí solo haces SELECT)
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir el encabezado Content-Type para recibir JSON u otros tipos
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connection.php';

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";

// Ejecutar la consulta
$result = $conexion->query($sql);

// Array donde guardaremos todos los productos
$productos = [];

// Mientras haya filas, agregarlas al array
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver el array en formato JSON
echo json_encode($productos);

// Cerrar la conexión
$conexion->close();
?>

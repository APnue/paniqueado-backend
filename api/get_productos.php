<?php
// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS (aunque aquí solo haces SELECT)
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir el encabezado Content-Type para recibir JSON u otros tipos
header("Access-Control-Allow-Headers: Content-Type");

// Datos de conexión a la base de datos
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conn->connect_error) {
    die("Error en conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";

// Ejecutar la consulta
$result = $conn->query($sql);

// Array donde guardaremos todos los productos
$productos = [];

// Mientras haya filas, agregarlas al array
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver el array en formato JSON
echo json_encode($productos);

// Cerrar la conexión
$conn->close();
?>

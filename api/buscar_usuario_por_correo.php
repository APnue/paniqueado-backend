<?php
// Encabezados para permitir CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Validación de parámetro
if (!isset($_GET['correo'])) {
    echo json_encode(['error' => 'Falta parámetro correo']);
    exit;
}

// Sanitizar entrada
$correo = $_GET['correo'];

// Incluir conexión a base de datos
require 'db_connection.php';

// Escapar el correo para evitar inyecciones
$correo_safe = $conexion->real_escape_string($correo);

// Consulta para buscar al usuario
$sql = "SELECT id, nombre, correo, telefono, recibir_notificaciones, rol FROM usuarios WHERE correo = '$correo_safe' LIMIT 1";

$result = $conexion->query($sql);

// Procesar resultado
if ($result && $result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    echo json_encode(['usuario' => $usuario]);
} else {
    echo json_encode(['usuario' => null]);
}

// Cerrar conexión
$conexion->close();
?>

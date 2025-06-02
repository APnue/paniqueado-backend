<?php
// Permitir que cualquier origen acceda a esta API
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir encabezado Content-Type para JSON
header("Access-Control-Allow-Headers: Content-Type");

// Responder rápido a peticiones OPTIONS (preflight) para CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Datos para conectar con la base de datos
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

// Crear conexión a MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hubo error al conectar
if ($conn->connect_error) {
    // Responder con error 500 y mensaje JSON
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error en la conexión: " . $conn->connect_error]);
    exit();
}

// Leer datos JSON enviados en el cuerpo de la petición POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que los datos necesarios estén presentes
if (!$data || !isset($data['nombre'], $data['precio'], $data['id_categoria'])) {
    http_response_code(400); // Bad request
    echo json_encode(["success" => false, "error" => "Faltan datos obligatorios o son inválidos"]);
    exit();
}

// Limpiar y preparar los datos para insertar
$nombre = $conn->real_escape_string($data['nombre']);
$precio = floatval($data['precio']);
$id_categoria = intval($data['id_categoria']);

// Crear la consulta SQL para insertar un nuevo producto
$sql = "INSERT INTO productos (nombre, precio, id_categoria) VALUES ('$nombre', $precio, $id_categoria)";

// Ejecutar la consulta y responder según el resultado
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500); // Error del servidor
    echo json_encode(["success" => false, "error" => $conn->error]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

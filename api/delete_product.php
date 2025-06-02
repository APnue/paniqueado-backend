<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir encabezado Content-Type para enviar JSON
header("Access-Control-Allow-Headers: Content-Type");

// Responder rápido a las peticiones OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Datos para conectar a la base de datos
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) { 
    die("Conexión fallida: " . $conn->connect_error); 
}

// Leer datos JSON que vienen en el cuerpo de la petición
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Obtener el id del producto a eliminar, o null si no viene
$id = $input['id'] ?? null;

// Validar que se haya recibido el id
if ($id === null) {
  echo json_encode(["success" => false, "error" => "No se recibió el id"]);
  exit();
}



// Armar la consulta para borrar el producto con ese id
$sql = "DELETE FROM productos WHERE id = $id";

// Ejecutar la consulta y devolver resultado
if ($conn->query($sql) === TRUE) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $conn->error]);
}

// Cerrar la conexión
$conn->close();
?>

<?php
// Permitir peticiones desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Solo permitir método GET
header("Access-Control-Allow-Methods: GET");
// Permitir cualquier encabezado
header("Access-Control-Allow-Headers: *");
// Indicar que la respuesta será JSON con codificación UTF-8
header("Content-Type: application/json; charset=UTF-8");

include 'db_connection.php';

// Consulta para obtener productos con su categoría
$sql = "SELECT 
          productos.id AS producto_id,
          productos.nombre AS producto_nombre,
          productos.precio,
          categorias.nombre AS categoria_nombre
        FROM productos
        INNER JOIN categorias ON productos.id_categoria = categorias.id";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Arreglo donde guardaremos todos los productos encontrados
$datos = [];

// Si hay resultados, los vamos agregando al arreglo $datos
if ($resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
  }
}

// Convertir el arreglo $datos a JSON y mostrarlo como respuesta
echo json_encode($datos);

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<?php
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

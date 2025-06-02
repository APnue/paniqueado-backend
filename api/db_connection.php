<?php
$host = 'ballast.proxy.rlwy.net'; // Este es el valor de RAILWAY_PRIVATE_DOMAIN
$port = 3306;
$user = 'root'; // MYSQLUSER
$pass = 'MWroSKktNmZigNeuIAyORjggCKArEdhy'; // MYSQL_ROOT_PASSWORD
$dbname = 'railway'; // MYSQL_DATABASE

$conexion = new mysqli($host, $user, $pass, $dbname, $port);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

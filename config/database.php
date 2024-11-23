<?php
$host = "localhost";
$dbname = "dronline03"; // Nombre de la base de datos
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión pasada de lanza a SQL";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>

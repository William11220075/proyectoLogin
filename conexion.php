<?php
$servername = "localhost"; // Servidor
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Deja vacío si no tienes contraseña
$dbname = "mi_base_de_datos"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4"); // Asegúrate de que el conjunto de caracteres sea correcto
?>
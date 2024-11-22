<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar sesión si es necesario

$servername = "localhost"; // Servidor
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Deja vacío si no tienes contraseña
$dbname = "base_datos"; // Nombre correcto de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $nombre = $_POST['username'];
    $clave = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Preparar y vincular
    $stmt = $conn->prepare("INSERT INTO usuarios (Correo, Nombre, Clave) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sss", $correo, $nombre, $clave);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso";
            header("Location: index.html"); // Redirigir al inicio de sesión después del registro
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error; // Muestra el error si ocurre
        }

        $stmt->close();
    } else {
        echo "Error en la preparación: " . $conn->error; // Muestra el error si ocurre en la preparación
    }
}

$conn->close();
?>

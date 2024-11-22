<?php
session_start(); // Iniciar sesión

// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Este debe coincidir con el campo del formulario
    $password = $_POST['password']; // Este debe coincidir con el campo del formulario

    // Consulta para verificar las credenciales del usuario
    $stmt = $conn->prepare("SELECT Clave FROM usuarios WHERE Nombre = ?"); // Cambia 'Nombre' si es necesario
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El usuario existe, ahora verifica la contraseña
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Contraseña correcta
            echo "<p style='color: green;'>¡Inicio de sesión exitoso! Bienvenido, " . htmlspecialchars($username) . ".</p>";
        } else {
            // Si la contraseña es incorrecta
            echo "<p style='color: red;'>Contraseña incorrecta.</p>";
        }
    } else {
        // Si el usuario no existe
        echo "<p style='color: red;'>El usuario si existe.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

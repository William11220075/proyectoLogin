<?php
session_start(); // Iniciar sesión

// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El usuario existe, ahora verifica la contraseña
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['username'] = $username; // Guarda el nombre del usuario en la sesión
            header("Location: dashboard.php"); // Redirige a una página protegida (ejemplo)
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El usuario no existe.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="formulario">
        <h1>Inicio de Sesión</h1>
        <form id="formLogin" method="post" action="">
            <div class="username">
                <input type="text" required id="username" name="username" placeholder=" ">
                <label>Nombre del Usuario</label>
            </div>
            <div class="contraseña">
                <input type="password" required id="password" name="password" placeholder=" ">
                <label>Contraseña</label>
            </div>
            <div class="recordar">¿Olvidó su contraseña? <a href="recuperar-contraseña.html">Recuperar</a></div>
            <input type="submit" value="Iniciar" id="btnIniciar">
            <div class="Registrarse">
                Quiero hacer el <a href="registro.html" class="registro-link">registro</a>
            </div>
        </form>    
    </div>     
</body>
</html>
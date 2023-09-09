<?php
session_start();

$servidor = 'localhost';
$database = 'login'; 
$usuario = 'root';
$clave = '';

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $clave, $database);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL segura para verificar las credenciales usando sentencias preparadas
    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: inicio_ex.php"); // Redirige a una página de bienvenida si el inicio de sesión es exitoso
        exit();
    } else {
        $_SESSION['login_error'] = "Las credenciales proporcionadas no son válidas. Por favor, inténtalo de nuevo.";
        header("Location: inicio_fa.php"); // Redirige de nuevo a la página de inicio de sesión si el inicio de sesión falla
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST"> <!-- Deja el atributo 'action' en blanco para que el formulario se envíe a sí mismo -->
            <div class="input-container">
                <input type="text" id="username" name="username" placeholder="Usuario" required>
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
        <a href="#">¿Perdiste tu contraseña?</a>
    </div>
</body>
</html>

<?php
$conexion->close();
?>


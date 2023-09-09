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
        echo "Bienvenido, " . $_SESSION['username'];
    } else {
        $_SESSION['login_error'] = "Las credenciales proporcionadas no son válidas. Por favor, inténtalo de nuevo.";
        echo "Inicio de Sesión Fallido";
        if(isset($_SESSION['login_error'])){
            echo '<p>' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
    }

    $stmt->close();
}

// Consulta SQL para obtener los nombres de usuario de los usuarios registrados
$sql = "SELECT username FROM usuarios";
$result = $conexion->query($sql);

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css"> <!-- Agrega el enlace al archivo CSS -->
    <title>Usuarios Registrados</title>
</head>
<body>
    <?php
    if (isset($_SESSION['username'])) {
        echo "<h1>Bienvenido, " . $_SESSION['username'] . "</h1>";
    } else {
        echo "<h1>No se ha iniciado sesión.</h1>";
    }

    // Comprueba si hay resultados
    if ($result->num_rows > 0) {
        echo "<h2>Usuarios Registrados</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Username</th></tr>";

        // Itera a través de los resultados y muestra los nombres de usuario en la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay usuarios registrados en la base de datos.";
    }
    ?>
</body>
</html>

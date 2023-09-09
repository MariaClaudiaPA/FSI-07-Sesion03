<?php
// Conexión a la base de datos 
$servidor = 'localhost';
$database = 'forms1'; 
$usuario = 'root';
$clave = '';

// Conexión a la base de datos
$conn = new mysqli($servidor, $usuario, $clave, $database);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);

}
// Recuperar el nombre del formulario
$nombre = $_POST["nombre"];

// Consulta SQL
$sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";

// Ejecutar la consulta
$result = $conn->query($sql);
// Mostrar los resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "Nombre: " . $row["nombre"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Usuario no encontrado";
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuarios</title>
    <link rel="stylesheet" href="est.css">

</head>
<body>
    <?php
    $servidor = 'localhost';
    $database = 'crud'; 
    $usuario = 'root';
    $clave = '';
    
    // Conexión a la base de datos
    $conexion = new mysqli($servidor, $usuario, $clave, $database);
    
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Función para crear un usuario
    function crearUsuario($nombre, $email, $edad) {
        global $conexion;
        $sql = "INSERT INTO usuarios (nombre, email, edad) VALUES ('$nombre', '$email', $edad)";
        if ($conexion->query($sql) === TRUE) {
            return "<span class='success'>Usuario creado correctamente.</span>";
        } else {
            return "<span class='error'>Error al crear el usuario: " . $conexion->error . "</span>";
        }
    }

    // Función para leer todos los usuarios
    function obtenerUsuarios() {
        global $conexion;
        $sql = "SELECT * FROM usuarios";
        $result = $conexion->query($sql);
        $usuarios = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }

    // Función para actualizar un usuario por ID
    function actualizarUsuario($id, $nuevoNombre, $nuevoEmail, $nuevaEdad) {
        global $conexion;
        $sql = "UPDATE usuarios SET nombre='$nuevoNombre', email='$nuevoEmail', edad=$nuevaEdad WHERE id=$id";
        if ($conexion->query($sql) === TRUE) {
            return "<span class='success'>Usuario actualizado correctamente.</span>";
        } else {
            return "<span class='error'>Error al actualizar el usuario: " . $conexion->error . "</span>";
        }
    }

    // Función para eliminar un usuario por ID
    function eliminarUsuario($id) {
        global $conexion;
        $sql = "DELETE FROM usuarios WHERE id=$id";
        if ($conexion->query($sql) === TRUE) {
            return "<span class='success'>Usuario eliminado correctamente.</span>";
        } else {
            return "<span class='error'>Error al eliminar el usuario: " . $conexion->error . "</span>";
        }
    }

    // Manejar formularios
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["crear"])) {
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $edad = $_POST["edad"];
            echo crearUsuario($nombre, $email, $edad);
        } elseif (isset($_POST["actualizar"])) {
            $id = $_POST["id"];
            $nuevoNombre = $_POST["nuevoNombre"];
            $nuevoEmail = $_POST["nuevoEmail"];
            $nuevaEdad = $_POST["nuevaEdad"];
            echo actualizarUsuario($id, $nuevoNombre, $nuevoEmail, $nuevaEdad);
        } elseif (isset($_POST["eliminar"])) {
            $id = $_POST["id"];
            echo eliminarUsuario($id);
        }
    }

    // Mostrar la tabla de usuarios
    $usuarios = obtenerUsuarios();
    if (!empty($usuarios)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Edad</th></tr>";
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario["id"] . "</td>";
            echo "<td>" . $usuario["nombre"] . "</td>";
            echo "<td>" . $usuario["email"] . "</td>";
            echo "<td>" . $usuario["edad"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron usuarios.";
    }

    $conexion->close();
    ?>

    <h2>Crear Usuario</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="edad">Edad:</label>
        <input type="number" name="edad" required>
        <button type="submit" name="crear">Crear</button>
    </form>

    <h2>Actualizar Usuario</h2>
    <form method="POST">
        <label for="id">ID del Usuario:</label>
        <input type="number" name="id" required>
        <label for="nuevoNombre">Nuevo Nombre:</label>
        <input type="text" name="nuevoNombre" required>
        <label for="nuevoEmail">Nuevo Email:</label>
        <input type="email" name="nuevoEmail" required>
        <label for="nuevaEdad">Nueva Edad:</label>
        <input type="number" name="nuevaEdad" required>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>

    <h2>Eliminar Usuario</h2>
    <form method="POST">
        <label for="id">ID del Usuario:</label>
        <input type="number" name="id" required>
        <button type="submit" name="eliminar">Eliminar</button>
    </form>
</body>
</html>

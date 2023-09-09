<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosM.css"> 
    <title>Inicio de Sesión Fallido</title>
</head>
<body class="login-error"> <!-- Aplica la clase 'login-error' para los estilos de inicio de sesión fallido -->
    <div class="container">
        <h1>Inicio de Sesión Fallido</h1>
        <?php
        if(isset($_SESSION['login_error'])){
            echo '<p>' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>
        <p><a href="login.html">Volver al formulario de inicio de sesión</a></p>
    </div>
</body>
</html>

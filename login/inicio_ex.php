<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosM.css"> 
    <title>Bienvenido</title>
</head>
<body class="welcome">
    <h1>Bienvenido, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Invitado'; ?></h1>
</body>
</html>


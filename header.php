<!-- header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Stock</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <div class="main_bar">
        <h2 id="brand">Stock</h2>
        <h3 class="info_pagina" id="infoPagina">Página</h3>
        <?php if(isset($_SESSION['id_usuario'])): ?>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
    <div class="info_general">
        <p id="infoGeneralText">No hay Mensajes</p>
    </div>
</body>
</html>
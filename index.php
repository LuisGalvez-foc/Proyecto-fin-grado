<?php
session_start(); // Asegúrate de que la sesión esté iniciada
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

include('header.php');
?>
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/index.css">

<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1> <!-- Saludo al usuario -->
        <div class="menu_central">
            <a href="consulta.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Consulta de stock producto.</p>
                    </div>
                </div>
            </a>
            
            <a href="alta_baja.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Alta/Baja de stock.</p>
                    </div>
                </div>
            </a>

            <a href="pedidos.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Orden de pedido.</p>
                    </div>
                </div>
            </a>

            <a href="ventas.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Ventas.</p>
                    </div>
                </div>
            </a>
            
            <a href="clientes.php?buscar=">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Registro de clientes.</p>
                    </div>
                </div>
            </a>

            <a href="administracion.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Panel de Administración.</p>
                    </div>
                </div>
            </a>

            <a href="estadisticas.php">
                <div class="menu">
                    <div class="boton">
                        <p class="texto_boton">Panel de estadísticas.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>
    <script>	
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Inicio';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Página de inicio. No hay mensajes";
    </script>
</body>
</html>
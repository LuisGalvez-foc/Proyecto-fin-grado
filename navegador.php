<?php
session_start(); // Asegúrate de que la sesión esté iniciada
?>
<!--******* ESTILOS EN BASE.CSS **********-->
<link rel="stylesheet" href="css/navegador.css">
<div class="navegador">
	<ul class="lista">
	<li class="link"><a href="index.php">Inicio</a></li>
        <li class="link"><a href="consulta.php">Consulta</a></li>
        <li class="link"><a href="pedidos.php">Pedidos</a></li>
        <li class="link"><a href="ventas.php">Ventas</a></li>
        <li class="link"><a href="clientes.php">Clientes</a></li>
        
		<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2): // Administrador ?>
            <li class="link"><a href="alta_baja.php">Alta/Baja</a></li>
            <li class="link"><a href="administracion.php">Administración</a></li>
            <li class="link"><a href="estadisticas.php">Estadísticas</a></li>
        <?php endif; ?>
	</ul>
</div><br>
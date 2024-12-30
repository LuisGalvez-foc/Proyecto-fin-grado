<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Ventas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Estadísticas de Ventas</h1>
        
        <div style="width: 80%; margin: auto;">
            <canvas id="graficoVentas"></canvas>
        </div>
    </div>

    <script>
    // Preparar datos de ventas
    const datos = {
        labels: [
            <?php
            $sql = "SELECT p.descripcion, SUM(ev.cantidad_vendida) as total 
                    FROM estadisticas_ventas ev
                    JOIN productos p ON ev.producto_id = p.id_producto
                    GROUP BY p.id_producto
                    LIMIT 5";
            $result = $con->query($sql);
            $productos = [];
            $ventas = [];
            while ($row = $result->fetch_assoc()) {
                echo "'" . $row['descripcion'] . "',";
                $ventas[] = $row['total'];
            }
            ?>
        ],
        datasets: [{
            label: 'Productos Más Vendidos',
            data: [<?php echo implode(',', $ventas); ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ]
        }]
    };

    // Crear gráfico
    const ctx = document.getElementById('graficoVentas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: datos,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Productos Más Vendidos'
                }
            }
        }
    });
    </script>
</body>
</html>
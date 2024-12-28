<?php
include('../global/conexion.php'); // Asegúrate de que la conexión esté incluida

if (isset($_GET['cadena'])) {
    $cadena = $_GET['cadena'];

    // Validar que la cadena no esté vacía
    if (empty($cadena)) {
        echo "Error: La cadena de búsqueda no puede estar vacía.";
        exit;
    }

    // Consulta para buscar productos cuya descripción contenga la cadena
    $sql = "SELECT * FROM productos WHERE descripcion LIKE ?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $con->error);
    }
    $searchTerm = "%" . $cadena . "%";
    $stmt->bind_param("s", $searchTerm);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        foreach ($resultado as $key) {
            echo '<div class="resultado-producto">';
            echo '<h4>Modelo: ' . htmlspecialchars($key['descripcion']) . '</h4>'; // Usar htmlspecialchars para evitar XSS
            echo '<p>Color: ' . htmlspecialchars ($key['color']) . '</p>';
            echo '<p>Talle: ' . htmlspecialchars($key['talle']) . '</p>';
            echo '<p>Cantidad: ' . htmlspecialchars($key['cantidad']) . '</p>';
            echo '<p>Precio: $' . number_format($key['precio'], 2) . '</p>';
            echo '<button onclick="agregarAlPedido(' . intval($key['id_producto']) . ')">Seleccionar</button>';
            echo '</div>';
        }
    } else {
        echo "No se encontraron productos.";
    }
} else {
    echo "Error: No se ha proporcionado la cadena de búsqueda.";
}
?>
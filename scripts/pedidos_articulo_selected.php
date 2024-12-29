<?php
include('../global/conexion.php');

if (isset($_GET['producto']) && is_numeric($_GET['producto'])) {
    $id_producto = intval($_GET['producto']);
    $query = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $con->error;
        exit;
    }

    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    if ($producto) {
        echo '<div class="producto-item" id="producto_' . $producto['id_producto'] . '" data-id="' . $producto['id_producto'] . '">';
        echo '<span class="art-selected">' . $producto['descripcion'] . '</span>';
        echo '<span class="cantidad">Cantidad: <span>1</span></span>';
        echo '<span class="precio">Precio: $<span>' . number_format($producto['precio'], 2) . '</span></span>';
        echo '<button onclick="removerProducto(' . $producto['id_producto'] . ')">Eliminar</button>';
        echo '</div>';
    } else {
        echo "Error: Producto no encontrado.";
    }
} else {
    echo "Error: ID de producto no válido.";
}
?>
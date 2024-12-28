<?php
include('../global/conexion.php');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
    $articulos_json = isset($_POST['articulos']) ? $_POST['articulos'] : null;

    if ($cliente_id === null || $articulos_json === null) {
        echo "Error: Datos incompletos";
        exit;
    }

    // Decodificar artículos
    $articulos = json_decode($articulos_json, true);
    $subtotal = 0;

    // Verificar si el cliente existe
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Insertar venta
        $query_venta = "INSERT INTO ventas (cliente_id, subtotal) VALUES (?, ?)";
        $stmt_venta = $con->prepare($query_venta);
        $stmt_venta->bind_param("id", $cliente_id, $subtotal);

        if ($stmt_venta->execute()) {
            $venta_id = $stmt_venta->insert_id; // Obtener el ID de la venta

            // Insertar artículos vendidos y actualizar la cantidad
            foreach ($articulos as $articulo) {
                $query_articulo = "SELECT precio, cantidad FROM productos WHERE id_producto = ?";
                $stmt_articulo = $con->prepare($query_articulo);
                $stmt_articulo->bind_param("i", $articulo['id']);
                $stmt_articulo->execute();
                $resultado_articulo = $stmt_articulo->get_result();
                $producto = $resultado_articulo->fetch_assoc();

                if ($producto) {
                    $precio = $producto['precio'];
                    $nueva_cantidad = $producto['cantidad'] - $articulo['cantidad'];

                    // Insertar en la tabla de ventas_articulos
                    $query_insert_articulo = "INSERT INTO ventas_articulos (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
                    $stmt_insert_articulo = $con->prepare($query_insert_articulo);
                    $stmt_insert_articulo->bind_param("iiid", $venta_id, $articulo['id'], $articulo['cantidad'], $precio);
                    $stmt_insert_articulo->execute();

                    // Actualizar la cantidad en la tabla de productos
                    if ($nueva_cantidad <= 0) {
                        // Si la cantidad llega a 0, eliminar el producto
                        $query_delete_producto = "DELETE FROM productos WHERE id_producto = ?";
                        $stmt_delete_producto = $con->prepare($query_delete_producto);
                        $stmt_delete_producto->bind_param("i", $articulo['id']);
                        $stmt_delete_producto->execute();
                    } else {
                        // Si la cantidad es mayor que 0, actualizar la cantidad
                        $query_update_producto = "UPDATE productos SET cantidad = ? WHERE id_producto = ?";
                        $stmt_update_producto = $con->prepare($query_update_producto);
                        $stmt_update_producto->bind_param("ii", $nueva_cantidad, $articulo['id']);
                        $stmt_update_producto->execute();
                    }
                }
            }

            echo "Venta guardada con éxito.";
        } else {
            echo "Error al guardar la venta: " . $stmt_venta->error;
        }
    } else {
        echo "Error: Cliente no encontrado.";
    }
} else {
    echo "Método no permitido.";
}
?>
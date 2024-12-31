<?php
include('../global/conexion.php');
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cliente_id'])) {
        $cliente_id = $_POST['cliente_id'];
    } else {
        echo "Error: No se ha pasado el ID del cliente.";
        exit;
    }

    $articulos_json = $_POST['articulos'];

    // Decodificar artículos
    $articulos = json_decode($articulos_json, true);

    // Verificar si el cliente existe
    echo "Valor de cliente_id: " . $cliente_id;
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    echo "Resultado de la consulta: ";
    var_dump($resultado);

    if ($resultado->num_rows > 0) {
        // Calcular el subtotal basado en los artículos
        $subtotal = 0;

        // Iniciar transacción para asegurar consistencia de datos
        $con->begin_transaction();

        try {
            // Insertar en la tabla ventas
            $sql_venta = "INSERT INTO ventas (cliente_id, subtotal) VALUES (?, ?)";
            $stmt_venta = $con->prepare($sql_venta);
            $stmt_venta->bind_param("id", $cliente_id, $subtotal);
            $stmt_venta->execute();
            $venta_id = $con->insert_id; // Obtener el ID de la venta insertada

            // Insertar los artículos en ventas_articulos
            $sql_venta_articulos = "INSERT INTO ventas_articulos (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
            $stmt_articulos = $con->prepare($sql_venta_articulos);

            foreach ($articulos as $articulo) {
                // Obtener el precio del producto
                $query_precio = "SELECT precio FROM productos WHERE id_producto = ?";
                $stmt_precio = $con->prepare($query_precio);
                $stmt_precio->bind_param("i", $articulo['id']);
                $stmt_precio->execute();
                $resultado_precio = $stmt_precio->get_result();
                $producto = $resultado_precio->fetch_assoc();

                if ($producto) {
                    $precio = $producto['precio'];
                    $cantidad = $articulo['cantidad'];
                    
                    // Calcular subtotal
                    $subtotal += $precio * $cantidad;

                    // Insertar artículo en ventas_articulos
                    $stmt_articulos->bind_param("iidi", $venta_id, $articulo['id'], $cantidad, $precio);
                    $stmt_articulos->execute();

                    // Actualizar el stock del producto
                    $sql_update_stock = "UPDATE productos SET cantidad = cantidad - ? WHERE id_producto = ?";
                    $stmt_stock = $con->prepare($sql_update_stock);
                    $stmt_stock->bind_param("ii", $cantidad, $articulo['id']);
                    $stmt_stock->execute();
                }
            }

            // Actualizar el subtotal de la venta
            $sql_update_venta = "UPDATE ventas SET subtotal = ? WHERE id_venta = ?";
            $stmt_update = $con->prepare($sql_update_venta);
            $stmt_update->bind_param("di", $subtotal, $venta_id);
            $stmt_update->execute();

            // Confirmar la transacción
            $con->commit();

            echo "Venta guardada con éxito.";

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $con->rollback();
            echo "Error al guardar la venta: " . $e->getMessage();
        }
    } else {
        echo "Error: Cliente no encontrado.";
    }
} else {
    echo "Método no permitido.";
}
?>
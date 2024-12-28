<?php
include('../global/conexion.php');
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $articulos_json = $_POST['articulos'];

    // Decodificar artículos
    $articulos = json_decode($articulos_json, true);

    // Verificar si el cliente existe
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Calcular el subtotal basado en los artículos
        $subtotal = 0; // Inicializa el subtotal

        foreach ($articulos as $articulo) {
            // Aquí deberías obtener el precio del artículo
            $query_precio = "SELECT precio FROM productos WHERE id_producto = ?";
            $stmt_precio = $con->prepare($query_precio);
            $stmt_precio->bind_param("i", $articulo['id']);
            $stmt_precio->execute();
            $resultado_precio = $stmt_precio->get_result();
            $producto = $resultado_precio->fetch_assoc();

            if ($producto) {
                $subtotal += $producto['precio'] * $articulo['cantidad'];
            }
        }

        // Obtener el ID de usuario de la sesión
        $id_usuario = $_SESSION['id_usuario']; // Asegúrate de que este valor esté establecido en la sesión

        // Insertar el pedido sin el campo saldo
        $sql_pedido = "INSERT INTO pedido (id_cliente, id_usuario, pagado_total, fecha_entrega, entregado, importe_total) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql_pedido);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $con->error);
        }

        // Asumiendo que ya has definido las variables necesarias
        $pagado_total = 0; // Cambia esto según tu lógica
        $fecha_entrega = date('Y-m-d'); // Cambia esto según tu lógica
        $entregado = 'No'; // Cambia esto según tu lógica
        $importe_total = $subtotal; // Cambia esto según tu lógica

        $stmt->bind_param("iiissd", $cliente_id, $id_usuario, $pagado_total, $fecha_entrega, $entregado, $importe_total);

        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        echo "Pedido guardado con éxito.";
    } else {
        echo "Error: Cliente no encontrado.";
    }
} else {
    echo "Método no permitido.";
}
?>
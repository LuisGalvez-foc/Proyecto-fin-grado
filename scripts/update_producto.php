<?php
include('../global/conexion.php');

// Verificar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $talle = $_POST['talle'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    // Manejo de la imagen (opcional)
    $ruta_imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $ruta_imagen = 'uploads/' . basename($imagen['name']);
        
        // Mover la imagen a la carpeta de uploads
        if (!move_uploaded_file($imagen['tmp_name'], '../' . $ruta_imagen)) {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Preparar la consulta de actualización
    if ($ruta_imagen) {
        // Si se sube una nueva imagen, actualizar incluyendo la imagen
        $sql = "UPDATE productos SET 
                descripcion = ?, 
                color = ?, 
                talle = ?, 
                cantidad = ?, 
                precio = ?, 
                imagen = ? 
                WHERE id_producto = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssiisi", $descripcion, $color, $talle, $cantidad, $precio, $ruta_imagen, $id_producto);
    } else {
        // Si no se sube imagen, actualizar sin modificar la imagen
        $sql = "UPDATE productos SET 
                descripcion = ?, 
                color = ?, 
                talle = ?, 
                cantidad = ?, 
                precio = ? 
                WHERE id_producto = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssiid", $descripcion, $color, $talle, $cantidad, $precio, $id_producto);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método no permitido.";
}
?>
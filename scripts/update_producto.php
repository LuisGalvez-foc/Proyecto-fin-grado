<?php
include('../global/conexion.php');

// Verificar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $talle = $_POST['talle'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $id = $_POST['id_producto'];

    // Manejo de la imagen
    $ruta_imagen = null; // Inicializar la variable de la ruta de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $ruta_imagen = 'uploads/' . basename($imagen['name']);
        
        // Mover la imagen a la carpeta de uploads
        if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
            // Si se subió una nueva imagen, actualizar la consulta para incluir la imagen
            $stmt = $con->prepare("UPDATE productos SET 
                                    descripcion = ?, 
                                    talle = ?, 
                                    color = ?, 
                                    cantidad = ?, 
                                    precio = ?, 
                                    imagen = ? 
                                    WHERE id_producto = ?");
            $stmt->bind_param("sssiisi", $descripcion, $talle, $color, $cantidad, $precio, $ruta_imagen, $id);
        } else {
            echo "Error al subir la imagen.";
            exit;
        }
    } else {
        // Si no se subió una nueva imagen, solo actualizar los demás campos
        $stmt = $con->prepare("UPDATE productos SET 
                                descripcion = ?, 
                                talle = ?, 
                                color = ?, 
                                cantidad = ?, 
                                precio = ? 
                                WHERE id_producto = ?");
        $stmt->bind_param("sssiid", $descripcion, $talle, $color, $cantidad, $precio, $id);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
}
?>
<script>
    function guardado() {
        alert('Modelo registrado correctamente');
        window.location = '../alta_baja.php?buscar=';
    }
</script>

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

    // Manejo de la imagen
    $imagen = $_FILES['imagen'];

    // Verificar si hubo un error en la subida
    if ($imagen['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Error al subir la imagen. Código de error: " . $imagen['error'] . "');</script>";
        exit;
    }

    // Validar el tipo de archivo (opcional)
    $tipo_archivo = mime_content_type($imagen['tmp_name']);
    if (strpos($tipo_archivo, 'image/') !== 0) {
        echo "<script>alert('El archivo subido no es una imagen.');</script>";
        exit;
    }

    // Ruta para almacenar la imagen físicamente
    $ruta_fisica = '../uploads/' . basename($imagen['name']);

    // Ruta que se guardará en la base de datos
    $ruta_publica = 'uploads/' . basename($imagen['name']);

    // Mover la imagen a la carpeta de uploads
    if (move_uploaded_file($imagen['tmp_name'], $ruta_fisica)) { 
        // Consulta para insertar el nuevo modelo
        $sql_guardar_nuevo = "INSERT INTO productos (descripcion, talle, color, cantidad, precio, imagen) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta
        $stmt = $con->prepare($sql_guardar_nuevo);
        $stmt->bind_param("ssssss", $descripcion, $talle, $color, $cantidad, $precio, $ruta_publica);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>guardado();</script>";
        } else {
            // Manejo de errores en caso de que la consulta falle
            if ($con->errno == 1062) {
                echo "<script>alert('No guardado !! ..El artículo ya existe');</script>";
                echo "<script>window.location = '../alta_baja.php?buscar=';</script>";
            } else {
                echo "<script>alert('Error al guardar el modelo: " . $stmt->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Error al mover la imagen a la carpeta de uploads.');</script>";
    }
}
?>

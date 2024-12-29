<?php
include('../global/conexion.php');

// Obtener la cadena de búsqueda desde la solicitud GET
$cadena = $_GET['cadena'] ?? ''; // Usar el operador null coalescing para evitar errores si 'cadena' no está definida

// Preparar la consulta base
if (empty($cadena)) {
    // Si no hay búsqueda, mostrar todos los productos
    $sql = "SELECT * FROM productos";
} else {
    // Si hay búsqueda, filtrar por descripción
    $sql = "SELECT * FROM productos WHERE descripcion LIKE ?";
}

// Preparar la declaración
$stmt = $con->prepare($sql);

// Verificar que la cadena no esté vacía
if (!empty($cadena)) {
    $searchTerm = "%" . $cadena . "%"; // Preparar la cadena de búsqueda
    $stmt->bind_param("s", $searchTerm); // Usar declaraciones preparadas para evitar inyección SQL
}

// Ejecutar la consulta
$stmt->execute();
$consulta = $stmt->get_result();

if ($consulta->num_rows > 0) { // Verificar si hay resultados
    foreach ($consulta as $key) {
        // Construir la ruta de la imagen
        $ruta_imagen = htmlspecialchars($key['imagen']); // Asegúrate de que esta sea la ruta correcta

        // Si la ruta es relativa, construye la URL completa
        if (strpos($ruta_imagen, 'http') === false) { // Verifica si la ruta no es absoluta
            $ruta_imagen = 'http://localhost/Proyecto-fin-grado/' . $ruta_imagen; // Construye la URL completa
        }
?>
        <tr>
            <td class="datos id_producto" width="5%"><?php echo htmlspecialchars($key['id_producto']); ?></td>
            <td class="datos categoria" width="20%"><?php echo htmlspecialchars($key['descripcion']); ?></td>
            <td class="datos color" width="10%"><?php echo htmlspecialchars($key['color']); ?></td>
            <td class="datos talle" width="5%"><?php echo htmlspecialchars($key['talle']); ?></td>
            <td class="datos cantidad" width="5%"><?php echo htmlspecialchars($key['cantidad']); ?></td>
            <td class="datos precio" width="6%"><?php echo htmlspecialchars($key['precio']); ?></td>
            <td class="datos imagen" width="10%">
                <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo htmlspecialchars($key['descripcion']); ?>" style="max-width: 100px; height: auto;">
            </td>
        </tr>
<?php
    }
} else {
    echo "<tr><td colspan='7'>No se encontraron productos.</td></tr>"; // Mensaje si no hay resultados
}
?>
<?php echo '<script>filas = ' . $con->affected_rows . ';</script>'; ?>
<?php
include('../global/conexion.php');

// Verificar que se ha enviado el ID del producto
if (isset($_GET['id_producto'])) {
    $id = $_GET['id_producto'];

    // Usar declaraciones preparadas para evitar inyecciones SQL
    $stmt = $con->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $consulta = $stmt->get_result();

    // Verificar si se encontró un producto
    if ($consulta->num_rows > 0) {
        $key = $consulta->fetch_assoc(); // Obtener el primer (y único) resultado
        ?>
        <label for="">Art</label>
        <input type="hidden" id="id_producto" name="id_producto" value="<?php echo htmlspecialchars($key['id_producto']); ?>">
        
        <label for="">Descripción</label>
        <input type="text" id="descripcion" value="<?php echo htmlspecialchars($key['descripcion']); ?>" maxlength="80" required>
        <br>
        
        <label for="">Color</label>
        <input type="text" id="color" value="<?php echo htmlspecialchars($key['color']); ?>" maxlength="30" required>
        <br>
        
        <label for="">Talle</label>
        <input type="text" id="talle" value="<?php echo htmlspecialchars($key['talle']); ?>" maxlength="8" required>
        
        <label for="">Cantidad</label>
        <input type="number" id="cantidad" value="<?php echo htmlspecialchars($key['cantidad']); ?>" maxlength="5">
        <br>
        
        <label for="">Precio</label>
        <input type="number" id="precio" value="<?php echo htmlspecialchars($key['precio']); ?>" maxlength="10">
        <br>

        <label for="">Imagen Actual</label>
        <img src="<?php echo htmlspecialchars($key['imagen']); ?>" alt="<?php echo htmlspecialchars($key['descripcion']); ?>" style="width: 100px; height: auto;">
        <br>

        <label for="">Cambiar Imagen</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">
        <br>

        <button id="guardar_edit" onclick="guardarEdicion(<?php echo $key['id_producto']; ?>)">Guardar Cambios</button>
        <button onclick="alternarVisibilidad(edit_div)">Cancelar</button <?php
    } else {
        echo "No se encontró el producto.";
    }

    $stmt->close(); // Cerrar la declaración
} else {
    echo "ID de producto no proporcionado.";
}
?>
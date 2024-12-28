<?php
include('../global/conexion.php');

$id = $_GET['id_producto'];

$sql = "SELECT * FROM productos WHERE id_producto = $id";

if ($consulta = $con->query($sql)) {
    // Verificar si se encontró un producto
    if ($consulta->num_rows > 0) {
        $key = $consulta->fetch_assoc(); // Obtener el primer (y único) resultado
        ?>
        <label for="" class="in_line">Art</label>
        <input type="text" id="id_producto" value="<?php echo $key['id_producto'];?>" disabled>
        
        <label for="" class="in_line">Descripción</label>
        <input type="text" id="descripcion" value="<?php echo $key['descripcion'];?>" maxlength="80" required>
        <br>
        
        <label for="" class="in_line">Color</label>
        <input type="text" id="color" value="<?php echo $key['color'];?>" maxlength="30" required>
        <br>
        
        <label for="" class="in_line">Talle</label>
        <input type="text" id="talle" value="<?php echo $key['talle'];?>" maxlength="8" required>
        
        <label for="" class="in_line">Cantidad</label>
        <input type="number" id="cantidad" value="<?php echo $key['cantidad'];?>" maxlength="5">
        <br>
        
        <label for="" class="in_line">Precio</label>
        <input type="number" id="precio" value="<?php echo $key['precio'];?>" maxlength="10">
        <br>

        <button id="guardar_edit" onclick="guardarEdicion(<?php echo $key['id_producto'];?>)">Guardar Cambios</button>
        <button onclick="alternarVisibilidad(edit_prod)">Cancelar</button>
        <?php
    } else {
        echo "No se encontró el producto.";
    }
} else {
    echo "Error en la consulta: " . $con->error;
}
?>
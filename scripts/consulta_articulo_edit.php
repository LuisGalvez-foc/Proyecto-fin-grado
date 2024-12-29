<?php
include('../global/conexion.php');

// Obtener la cadena de búsqueda desde la solicitud GET
$cadena = $_GET['cadena'];

// Consulta para buscar productos cuya descripción contenga la cadena
$sql = "SELECT * FROM productos WHERE descripcion LIKE '%$cadena%'";

if ($cadena != '') {
    $consulta = $con->query($sql);

    if ($consulta) {    
        foreach ($consulta as $key) {        
            ?>
            <tr>
                <td class="datos id_producto" width="4%"><?php echo $key['id_producto']; ?></td>
                <td class="datos categoria" width="18%"><?php echo $key['descripcion']; ?></td>
                <td class="datos color" width="8%"><?php echo $key['color']; ?></td>
                <td class="datos talle" width="5%"><?php echo $key['talle']; ?></td>
                <td class="datos cantidad" width="5%"><?php echo $key['cantidad']; ?></td>
                <td class="datos precio" width="8%"><?php echo $key['precio']; ?></td>
                <td class="datos imagen" width="10%">
                    <img src="<?php echo htmlspecialchars($key['imagen']); ?>" alt="<?php echo htmlspecialchars($key['descripcion']); ?>" style="max-width: 100px; height: auto;">
                </td>
                <td class="datos botones" width="16%">
                    <button class="boton_edit_prod" onclick="editarProducto(<?php echo $key['id_producto']; ?>)">Editar</button>
                    <button onclick="borrarProducto(<?php echo $key['id_producto']; ?>)">Borrar</button>
                </td>
            </tr>
            <?php
        }
    }
}
?>
<?php echo '<script>filas = ' . $con->affected_rows . ';</script>'; ?>
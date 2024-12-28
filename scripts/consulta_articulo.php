<?php
include('../global/conexion.php');

// Obtener la cadena de búsqueda desde la solicitud GET
$cadena = $_GET['cadena'];

// Consulta para buscar productos cuya descripción contenga la cadena
$sql = "SELECT * FROM productos WHERE descripcion LIKE '%$cadena%'";

// Verificar que la cadena no esté vacía
if ($cadena != '') {
    $consulta = $con->query($sql);

    if ($consulta) {    
        foreach ($consulta as $key) {        
            ?>
            <tr>
                <td class="datos id_producto" width="5%"><?php echo $key['id_producto']; ?></td>
                <td class="datos categoria" width="20%"><?php echo $key['descripcion']; ?></td>
                <td class="datos color" width="10%"><?php echo $key['color']; ?></td>
                <td class="datos talle" width="5%"><?php echo $key['talle']; ?></td>
                <td class="datos cantidad" width="5%"><?php echo $key['cantidad']; ?></td>
                <td class="datos precio" width="6%"><?php echo $key['precio']; ?></td>
            </tr>
            <?php
        }
    }
}
?>
<?php echo '<script>filas = ' . $con->affected_rows . ';</script>'; ?>
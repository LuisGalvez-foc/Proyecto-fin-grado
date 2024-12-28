<?php
include('../global/conexion.php');

// Verificar si se ha enviado el parámetro 'cadena'
if (isset($_GET['cadena'])) {
    $cadena = $_GET['cadena'];

    // Consulta para buscar clientes cuyo nombre completo contenga la cadena
    $sql = "SELECT * FROM clientes WHERE nombre_completo LIKE '%$cadena%'";

    if ($cadena != '') {
        $consulta = $con->query($sql);

        if ($consulta) {    
            // Crear una tabla para mostrar los resultados
            echo '<table>';
            echo '<tr>
                    <th>ID Cliente</th>
                    <th>Nombre Completo</th>
                    <th>Descuento</th>
                    <th>Acción</th>
                  </tr>';
            
            foreach ($consulta as $key) {        
                ?>
                <tr>
                    <td id="cliente_id" width="10%"><?php echo $key['id_cliente']; ?></td>
                    <td class="datos categoria" id="nombre_cliente" width="50%"><?php echo $key['nombre_completo']; ?></td>
                    <td class="datos color" width="15%"><?php echo $key['descuento']; ?></td>
                    <td class="datos" width="25%">
                        <button id="boton_seleccion_cliente" onclick="selectedCliente(<?php echo $key['id_cliente']; ?>, <?php echo $key['descuento']; ?>)">Seleccionar</button>
                    </td>
                </tr>
                <?php
            }
            echo '</table>'; // Cerrar la tabla
        }
    }
} else {
    echo "Error: No se ha proporcionado la cadena de búsqueda.";
}
?>
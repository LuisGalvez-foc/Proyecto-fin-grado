<?php 
include('../global/conexion.php');

// Obtener la categoría desde la solicitud GET
$categoria = $_GET['id_categoria'];

// Consulta para obtener modelos según la categoría
$sql_modelo = "SELECT modelo FROM modelo WHERE categoria = $categoria";

// Ejecutar la consulta
$consulta_mod = $con->query($sql_modelo);

// Verificar si se obtuvieron resultados
if ($consulta_mod) {
    // Recorrer los resultados y generar opciones para el select
    foreach ($consulta_mod as $mod) {
        ?>
        <option class="opcion" value="<?php echo $mod['modelo']; ?>"><?php echo $mod['modelo']; ?></option>
        <?php
    }
} else {
    // Opcional: manejar el caso en que no se encuentren modelos
    echo '<option class="opcion" value="">No se encontraron modelos</option>';
}
?>
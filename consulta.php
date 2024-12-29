<?php
include('header.php');
include('global/conexion.php');
include('navegador.php');
?>
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/consulta.css">
<div class="container">

    <input type="text" id="entrada">
    <button id="mostrar_todos" onclick="mostrarTodos()">Mostrar Todos los Productos</button>
    <table id="resultados">
        <tr id="fila">
            <td id="dato" width="5%">Art</td>
            <td id="dato" width="20%">Modelo</td>
            <td id="dato" width="10%">Color</td>
            <td id="dato" width="5%">Talle</td>
            <td id="dato" width="5%">Cant</td>
            <td id="dato" width="6%">Precio</td>
            <td id="dato" width="10%">Imagen</td>
            <!--<td id="dato" width="16%">Accion</td>-->
        </tr>
    </table>
    <table id="respuesta"></table>
</div>
<script>
    let infoPagina = document.getElementById('infoPagina');
    infoPagina.innerHTML = 'Consulta';
    let infoGeneral = document.getElementById('infoGeneralText');
    infoGeneral.innerHTML = "Página de inicio. No hay mensajes";

    var div_respuesta = document.getElementById('respuesta');
    var entrada = document.getElementById('entrada');
    entrada.addEventListener("keyup", function() {
       
        consultarBaseDatos('GET', 'scripts/consulta_articulo.php?cadena=' + entrada.value, div_respuesta);
    });
    function mostrarTodos() {
    entrada.value = ''; // Limpiar el campo de búsqueda
    consultarBaseDatos('GET', 'scripts/consulta_articulo.php', div_respuesta); // Llamar al script sin cadena
}

</script>
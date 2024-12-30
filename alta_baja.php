<?php
include('header.php');
include('navegador.php');
?>
<link rel="stylesheet" href="css/alta_baja.css">
<link rel="stylesheet" href="css/consulta.css">
<script src="js/scripts.js"></script>

<body>
    <div class="container">
        <div class="separador">
            <p>Presiona Cargar articulo nuevo para ingresar un articulo por primera vez</p>
        </div>
        <button id="cargar_nuevo_div">Cargar Articulo Nuevo</button>
        <hr>
        <div id="art_nuevo">
            <form action="scripts/guardar_modelo_nuevo.php" method="POST" enctype="multipart/form-data">
                <label for="">Descripción</label>
                <input type="text" class="campos" name="descripcion" maxlength="80" required>
                <span class="pista">Hasta 80 caracteres. Obligatorio</span><br>

                <label for="">Color</label>
                <input type="text" class="campos" name="color" maxlength="30" required>
                <span class="pista">Hasta 30 caracteres. Obligatorio</span><br>

                <label for="">Cantidad</label>
                <input type="number" class="campos" name="cantidad" value="0" maxlength="5">
                <span class="pista" required>Numero positivo. Predeterminado 0.</span><br>

                <label for="">Talle</label>
                <input type="text" class="campos" name="talle" maxlength="8" required>
                <span class="pista">Talle. Número o letra. Obligatorio</span><br>

                <label for="">Precio</label>
                <input type="number" class="campos" name="precio" maxlength="10">
                <span class="pista">Pesos SIN centavos.</span><br>

                <label for="">Imagen del Producto</label>
                <input type="file" class="campos" name="imagen" accept="image/*" required>
                <span class="pista">Selecciona una imagen del producto. Obligatorio.</span><br>
                <br>
                <button id="guardar_nuevo_modelo" type="submit">Guardar Modelo Nuevo</button>
            </form>
        </div>

        <br>
        <div class="info">Modificar stock</div>
        <div id="art_agregar_stock">
            <div class="entrada">
                <input type="text" id="entrada">
                <table id="resultados">
                    <tr id="fila">
                        <td id="dato" width="4%">Art</td>
                        <td id="dato" width="18%">Modelo</td>
                        <td id="dato" width="10%">Color</td>
                        <td id="dato" width="5%">Talle</td>
                        <td id="dato" width="5%">Cant</td>
                        <td id="dato" width="8%">Precio</td>
                        <td id="dato" width="10%">Imagen</td> <!-- Añadir columna para la imagen -->
                        <td id="dato" width="16%">Acción</td>
                    </tr>
                    <tbody id="respuesta"></tbody> <!-- Asegúrate de que el tbody esté correctamente definido -->
                </table>
            </div>
        </div>
        <div id="edit_div">
            <div id="edit_interface">
                <label for="">Editar Producto.</label>
            </div>
        </div>
    </div>

    <script>
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Alta y Baja de productos';


        //------------- variables -----------
        var edit_prod = document.getElementById('edit_interface');
        var art_nuevo_div = document.getElementById('art_nuevo');
        var boton_div_nuevo = document.getElementById('cargar_nuevo_div');

        //----------- controles de eventos ---------
        boton_div_nuevo.addEventListener("click", function() {
            alternarVisibilidad(art_nuevo_div);
        });

        //--------- FUNCIONES--------
        var div_respuesta = document.getElementById('respuesta');
        var entrada = document.getElementById('entrada');
        entrada.addEventListener("keyup", function() {
            consultarBaseDatos('GET', 'scripts/consulta_articulo_edit.php?cadena=' + entrada.value, div_respuesta);
        });

        var editarProducto = function(id_producto) {
            consultarBaseDatos('GET', 'scripts/cargar_articulo_edit.php?id_producto=' + id_producto, edit_prod);
            alternarVisibilidad(edit_prod);
        }

        var guardarEdicion = function(id) {
            let e_id_producto = document.getElementById('id_producto'); // Corregido
            let e_descripcion = document.getElementById('descripcion');
            let e_talle = document.getElementById('talle');
            let e_color = document.getElementById('color');
            let e_cantidad = document.getElementById('cantidad');
            let e_precio = document.getElementById('precio');

            if (e_id_producto && e_descripcion && e_talle && e_color && e_cantidad && e_precio) {
                actualizarProducto(e_id_producto.value, e_descripcion.value, e_talle.value, e_color.value, e_cantidad.value, e_precio.value);
                alternarVisibilidad(edit_prod);
            } else {
                console.error("Uno o más elementos no están definidos.");
            }
        }

        var actualizarProducto = function(id, descripcion = null, talle = null, color = null, cantidad = null, precio = null) {
            let conn = new XMLHttpRequest();
            conn.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert('Guardado');
                }
            }
            conn.open('GET', 'scripts/update_producto.php?id_producto=' + id + '&color=' + color + '&talle=' + talle + '&precio=' + precio + '&descripcion=' + descripcion + '&cantidad=' + cantidad, true);
            conn.send();
        }
    </script>
</body>
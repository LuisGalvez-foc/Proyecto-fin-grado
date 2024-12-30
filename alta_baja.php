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
    </script>
</body>
<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');
?>

<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/clientes.css">

<body>
    <div class="container">

        <!--////////SECCION CLIENTE INDIVIDUAL LISTAR-->
        <section class="buscar_cliente" id="lista_clientes">
            <div id="buscar_cliente">
                <label for="cadena">Buscar cliente:</label>
                <input type="text" name="cadena" id="cadena" placeholder="Nombre, Ciudad o Provincia">
                <button onclick="buscarClientes()">Buscar</button>
                <button onclick="window.location.href='clientes.php'">Todos los clientes</button>
                <hr>
            </div>

            <table>
                <tr>
                    <td>Nombre</td>
                    <td>Dirección</td>
                    <td>Ciudad</td>
                    <td>Provincia</td>
                    <td>Teléfono</td>
                    <td>Email</td>
                    <td>C.P.</td>
                    <td>DNI</td>
                    <td>Rev.</td>
                    <td>Desc.</td>
                </tr>

                <?php
                $buscar = ''; // Inicializa la variable de búsqueda

                if (isset($_GET['cadena'])) {
                    $buscar = $_GET['cadena']; // Obtiene el valor de búsqueda
                }

                // Construcción de la consulta SQL
                $sql_consultar_cliente = "SELECT * FROM clientes WHERE nombre_completo LIKE '%$buscar%' OR ciudad LIKE '%$buscar%' OR provincia LIKE '%$buscar%' ORDER BY nombre_completo";

                // Ejecutar la consulta
                $consulta_cliente = $con->query($sql_consultar_cliente);

                // Verificar si la consulta fue exitosa
                if ($consulta_cliente === false) {
                    echo "Error en la consulta: " . $con->error; // Mostrar el error de la consulta
                } else {
                    // Verificar si hay resultados
                    if ($consulta_cliente->num_rows > 0) {
                        foreach ($consulta_cliente as $row) {
                ?>
                            <tr>
                                <td class="datos"><?php echo $row['nombre_completo']; ?></td>
                                <td class="datos"><?php echo $row['direccion']; ?></td>
                                <td class="datos"><?php echo $row['ciudad']; ?></td>
                                <td class="datos"><?php echo $row['provincia']; ?></td>
                                <td class="datos"><?php echo $row['telefono']; ?></td>
                                <td class="datos"><?php echo $row['email']; ?></td>
                                <td class="datos"><?php echo $row['codigo_postal']; ?></td>
                                <td class="datos"><?php echo $row['dni']; ?></td>
                                <td class="datos"><?php echo $row['revendedora'] == 1 ? 'Sí' : 'No'; ?></td>
                                <td class="datos"><?php echo $row['descuento']; ?></td>
                            </tr>
                <?php
                        }
                    } else {
                        echo "<tr><td colspan='10'>No se encontraron clientes.</td></tr>"; // Mensaje si no hay resultados
                    }
                }
                ?>
            </table>
            <br>
            <hr>
            <span><?php echo 'Cantidad de Registros coincidentes: ' . $con->affected_rows; ?></span>
        </section>

        <hr>

        <!--//////////////////// SECCION CLIENTE NUEVO REGISTRO-->
        <section id="ingresar_cliente">
            <div class="boton">
                <button id="boton_cliente">Ingresar Nuevo Cliente</button>
            </div>
            <div id="form_cliente" style="display: none;">
                <form id="formNuevoCliente">
                    <h2>Registrar Cliente</h2>
                    <label for="nombre_completo">Nombre y Apellido</label>
                    <input type="text" name="nombre_completo" maxlength="80" required placeholder="Ej. Juan Pérez">
                <br>
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" maxlength="200" placeholder="Ej. Calle Falsa 123">
                    <br>
                    <label for="ciudad">Ciudad</label>
                    <input type="text" name="ciudad" maxlength="100" placeholder="Ej. Buenos Aires">
                    <br>
                    <label for="provincia">Provincia</label>
                    <select name="provincia" required>
                        <option value="">Seleccione Provincia</option>
                        <option value="Ávila">Ávila</option>
                        <option value="Badajoz">Badajoz</option>
                        <option value="Baleares">Baleares</option>
                        <option value="Barcelona">Barcelona</option>
                        <option value="Burgos">Burgos</option>
                        <option value="Cáceres">Cáceres</option>
                        <option value="Cádiz">Cádiz</option>
                        <option value="Castellón">Castellón</option>
                        <option value="Ciudad Real">Ciudad Real</option>
                        <option value="Córdoba">Córdoba</option>
                        <option value="La Coruña">La Coruña</option>
                        <option value="Cuenca">Cuenca</option>
                        <option value="Gerona">Gerona</option>
                        <option value="Granada">Granada</option>
                        <option value="Guadalajara">Guadalajara</option>
                        <option value="Huelva">Huelva</option>
                        <option value="Huesca">Huesca</option>
                        <option value="Jaén">Jaén</option>
                        <option value="La Rioja">La Rioja</option>
                        <option value="Madrid">Madrid</option>
                        <option value="Málaga">Málaga</option>
                        <option value="Murcia">Murcia</option>
                        <option value="Navarra">Navarra</option>
                        <option value="Orense">Orense</option>
                        <option value="Palencia">Palencia</option>
                        <option value="Las Palmas">Las Palmas</option>
                        <option value="Pontevedra">Pontevedra</option>
                        <option value="Salamanca">Salamanca</option>
                        <option value="Santa Cruz de Tenerife">Santa Cruz de Tenerife</option>
                        <option value="Segovia">Segovia</option>
                        <option value="Sevilla">Sevilla</option>
                        <option value="Soria">Soria</option>
                        <option value="Tarragona">Tarragona</option>
                        <option value="Teruel">Teruel</option>
                        <option value="Toledo">Toledo</option>
                        <option value="Valencia">Valencia</option>
                        <option value="Valladolid">Valladolid</option>
                        <option value="Vizcaya">Vizcaya</option>
                        <option value="Zamora">Zamora</option>
                        <option value="Zaragoza">Zaragoza</option>
                    </select>
                    <br>
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" maxlength="18" placeholder="Ej. 1234567890">
                    <br>
                    <label for="email">Email</label>
                    <input type="text" name="email" maxlength="150" placeholder="Ej. ejemplo@correo.com">
                    <br>
                    <label for="cod_postal">Código Postal</label>
                    <input type="number" name="cod_postal" maxlength="6" placeholder="Ej. 12345">
                    <br>
                    <label for="dni">DNI</label>
                    <input type="number" name="dni" maxlength="9" required placeholder="Ej. 12345678">
                    <br>
                    <label for="revendedora">Es revendedor/a</label>
                    <input type="radio" value="1" name="revendedora"> Sí
                    <input type="radio" value="0" name="revendedora" checked> No
                    <br>
                    <label for="descuento">Descuento (%)</label>
                    <input type="number" name="descuento" value="0" maxlength="4" placeholder="Ej. 10">
                    <br>
                    <input type="submit" value="Guardar Registro">
                    <button type="button" id="cancelar_btn">Cancelar</button>
                </form>
            </div>
        </section>

    </div>

    <script>
        document.getElementById('boton_cliente').addEventListener('click', function() {
            // Ocultar la sección de lista de clientes y mostrar solo el formulario
            document.getElementById('lista_clientes').style.display = 'none';
            document.getElementById('form_cliente').style.display = 'block';
        });
        document.getElementById('cancelar_btn').addEventListener('click', function() {
    document.getElementById('form_cliente').style.display = 'none'; // Oculta el formulario
    document.getElementById('lista_clientes').style.display = 'block'; // Muestra la lista de clientes
});

        document.getElementById('formNuevoCliente').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

            var formData = new FormData(this); // Obtiene los datos del formulario

            // Enviar los datos usando AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'scripts/guardar_cliente.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Aquí puedes manejar la respuesta del servidor
                    alert(xhr.responseText); // Muestra un mensaje de éxito o error
                    // Recargar la página después de guardar el cliente
                    location.reload();
                }
            };
            xhr.send(formData); // Envía los datos del formulario
        });
    </script>

</body>
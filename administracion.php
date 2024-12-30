<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');

// Verificar si el usuario es administrador
if ($_SESSION['rol'] != 2) {
    header("Location: index.php"); // Redirigir si no es administrador
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/administracion.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2>Panel de Administración</h2>
        </div>

        <!-- Botones para mostrar el formulario de registro de usuario y la tabla de usuarios -->
        <div class="admin-nav-buttons">
            <button id="btn_registrar_usuario">Registrar Usuarios</button>
            <button id="btn_mostrar_usuarios">Mostrar Usuarios</button>
            <button id="btn_mostrar_productos">Mostrar Productos</button>
        </div>

        <div id="tabla_productos" class="admin-product-table" style="display: none;">
            <h3>Productos Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Color</th>
                        <th>Talle</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se llenarán los productos desde la base de datos -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para registrar nuevos usuarios -->
        <div id="form_registrar_usuario" class="admin-form" style="display: none;">
            <h3>Registrar Nuevo Usuario</h3>
            <form action="scripts/guardar_usuario.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required>

                <label for="nick">Nombre de Usuario:</label>
                <input type="text" name="nick" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required>

                <label for="pswd">Contraseña:</label>
                <input type="password" name="pswd" required>

                <button type="submit">Registrar</button>
            </form>
        </div>

        <!-- Tabla para mostrar usuarios -->
        <div id="tabla_usuarios" class="admin-user-table" style="display: none;">
            <h3>Usuarios Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Nick</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta para obtener todos los usuarios
                    $sql = "SELECT * FROM usuarios";
                    $resultado = $con->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($usuario = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $usuario['id_usuario'] . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['apellido']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['nick']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['telefono']) . "</td>";
                            echo "<td>" . ($usuario['rol'] == 1 ? 'Trabajador' : 'Administrador') . "</td>";
                            echo "<td class='admin-action-buttons'>
                                    <button class='btn-edit' onclick='borrarUsuario(" . $usuario['id_usuario'] . ")'>Borrar</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay usuarios registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="edit_div" style="display: none;">
    <h3>Editar Producto</h3>
    <form id="form_editar_producto" class="admin-form">
        <input type="hidden" id="id_producto" name="id_producto">
        
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" required>

        <label for="talle">Talle:</label>
        <input type="text" id="talle" name="talle" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>

        <button type="button" id="btn_guardar_edicion">Guardar Cambios</button>
    </form>
</div>
    </div>
    <script src="js/scripts.js"></script>
    <script>
        // Script para alternar la visibilidad del formulario y la tabla
        document.getElementById('btn_registrar_usuario').addEventListener('click', function() {
            var form = document.getElementById('form_registrar_usuario');
            var tabla = document.getElementById('tabla_usuarios');
            form.style.display = form.style.display === "none" ? "block" : "none"; // Alternar el formulario
            tabla.style.display = "none"; // Ocultar la tabla
        });

        document.getElementById('btn_mostrar_usuarios').addEventListener('click', function() {
            var form = document.getElementById('form_registrar_usuario');
            var tabla = document.getElementById('tabla_usuarios');
            tabla.style.display = tabla.style.display === "none" ? "block" : "none"; // Alternar la tabla
            form.style.display = "none"; // Ocultar el formulario
        });

        function borrarUsuario(id) {
            // Lógica para borrar el usuario
            if (confirm("¿Estás seguro de que deseas borrar este usuario?")) {
                window.location.href = "scripts/borrar_usuario.php?id=" + id; // Redirigir a un script para borrar el usuario
            }
        }

        document.getElementById('btn_mostrar_productos').addEventListener('click', function() {
            consultarBaseDatos('GET', 'scripts/consulta_articulo.php', document.querySelector('#tabla_productos tbody'));
            document.getElementById('tabla_productos').style.display = 'block'; // Mostrar la tabla
        });

        function editarProducto(id_producto) {
            // Lógica para obtener los datos del producto y llenar el formulario
            consultarBaseDatos('GET', 'scripts/cargar_articulo_edit.php?id_producto=' + id_producto, document.getElementById('edit_div'));
            document.getElementById('edit_div').style.display = 'block'; // Mostrar el formulario de edición
        }

        document.getElementById('btn_guardar_edicion').addEventListener('click', function() {
            guardarEdicion(document.getElementById('id_producto').value);
        });

        function guardarEdicion(id) {
            let e_descripcion = document.getElementById('descripcion').value;
            let e_color = document.getElementById('color').value;
            let e_talle = document.getElementById('talle').value;
            let e_cantidad = document.getElementById('cantidad').value;
            let e_precio = document.getElementById('precio').value;

            // Lógica para enviar los datos al servidor
            let conn = new XMLHttpRequest();
            conn.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert('Producto actualizado con éxito');
                    // Opcional: Ocultar el formulario y refrescar la tabla de productos
                    document.getElementById('edit_div').style.display = 'none';
                    consultarBaseDatos('GET', 'scripts/consulta_articulo.php', document.querySelector('#tabla_productos tbody'));
                }
            }
            conn.open('POST', 'scripts/update_producto.php', true);
            conn.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            conn.send('id_producto=' + id + '&descripcion=' + e_descripcion + '&color=' + e_color + '&talle=' + e_talle + '&cantidad=' + e_cantidad + '&precio=' + e_precio);
        }

        function mostrarTablaUsuarios() {
            document.getElementById('tabla_usuarios').style.display = 'block';
            document.getElementById('form_registrar_usuario').style.display = 'none';
        }

        function mostrarFormularioRegistro() {
            document.getElementById('form_registrar_usuario').style.display = 'block';
            document.getElementById('tabla_usuarios').style.display = 'none';
        }

        function mostrarProductos() {
            document.getElementById('form_registrar_usuario').style.display = 'none';
            document.getElementById('edit_div').style.display = 'none';
            document.getElementById('tabla_productos').style.display = 'block';
        }
    </script>
</body>

</html>
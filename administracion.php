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
    <style>
        .admin-container {
    animation: fadeIn 0.5s ease }
    .admin-form button[type="submit"] {
        background-color: #6A0572; /* Púrpura oscuro */
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        font-size: 1em;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 15px;
        text-transform: uppercase;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    .admin-form button[type="submit"]:hover {
        background-color: #AB83A1; /* Púrpura suave */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    
    .admin-form button[type="submit"]:active {
        transform: translateY(1px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    .admin-form button[type="submit"]:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(106, 5, 114, 0.4);
    }
    </style>
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
        </div>

        <!-- Formulario para registrar nuevos usuarios -->
        <div id="form_registrar_usuario" class="admin-form">
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
        <div id="tabla_usuarios" class="admin-user-table">
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
    </div>

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
    </script>
</body>
</html>
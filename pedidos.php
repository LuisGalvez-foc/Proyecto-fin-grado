<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');
?>
<link rel="stylesheet" href="css/ventas.css">
<link rel="stylesheet" href="css/consulta.css">
<script src="js/scripts.js"></script>

<body>
    <div class="container">
        <h2>Nuevo Pedido</h2>
        <button onclick="alternarVisibilidad(nuevo_pedido)" id="bot-nuevo">Nuevo Pedido</button>

        <div id="nuevo_pedido" style="display: none;">
            <div class="section">
                <h3>Seleccionar Cliente</h3>
                <input type="text" id="cadena_cliente" placeholder="Buscar cliente...">
                <div id="respuesta_cliente" class="resultados"></div>
                <input type="hidden" id="cliente_id" value="">
                <input type="hidden" id="cliente_descuento" value="0"> <!-- Campo oculto para el descuento -->
                <div id="cliente-seleccionado" class="cliente-detalle">
                    <h4>Cliente Seleccionado:</h4>
                    <p id="cliente_seleccionado_nombre">Ningún cliente seleccionado</p>
                    <button id="quitar_cliente" style="display: none;" onclick="quitarCliente()">Quitar Cliente</button>
                </div>
            </div>

            <div class="section">
                <h3>Seleccionar Productos</h3>
                <input type="text" id="entrada_producto" placeholder="Buscar producto...">
                <div id="respuesta_producto" class="resultados"></div>
            </div>

            <div class="section">
                <h3>Carrito de Pedido</h3>
                <div id="carrito-body" class="carrito-body">
                    <!-- Los productos se agregarán aquí -->
                </div>
                <div class="totales">
                    <span>Subtotal: $<span id="subtotal">0.00</span></span>
                    <span>Descuento: $<span id="descuento">0.00</span></span>
                    <span>Total: $<span id="total">0.00</span></span>
                </div>
            </div>

            <div class="acciones-pedido">
                <button id="guardar_pedido">Guardar Pedido</button>
            </div>

        </div>
        <h2>Lista de Pedidos</h2>
        <div class="lista-pedidos">
            <?php
            // Suponiendo que tienes una consulta que obtiene los pedidos
            $query = "SELECT p.id_pedido, p.id_cliente, p.entregado, p.importe_total, pl.id_producto, pr.descripcion, pr.imagen 
                      FROM pedido p 
                      JOIN pedido_lista pl ON p.id_pedido = pl.id_pedido 
                      JOIN productos pr ON pl.id_producto = pr.id_producto"; // Ajusta la consulta según tu lógica
            $result = $con->query($query);

            while ($pedido = $result->fetch_assoc()) {
            ?>
                <div class="pedido-item">
                    <h3>Pedido ID: <?php echo $pedido['id_pedido']; ?></h3>
                    <p>Cliente ID: <?php echo $pedido['id_cliente']; ?></p>
                    <p>Estado: <?php echo $pedido['entregado']; ?></p>
                    <p>Importe Total: $<?php echo $pedido['importe_total']; ?></p>
                    <p>Producto: <?php echo $pedido['descripcion']; ?></p>
                    <img src="<?php echo htmlspecialchars($pedido['imagen']); ?>" alt="<?php echo htmlspecialchars($pedido['descripcion']); ?>" style="max-width: 100px; height: auto;">

                    <!-- Botón para cambiar el estado a entregado -->
                    <button onclick="cambiarEstadoEntregado(<?php echo $pedido['id_pedido']; ?>)">Marcar como Entregado</button>
                </div>
            <?php
            }
            ?>
        </ ```php
        </div>
    </div><!--container-->

    <span id="ultimo_pedido" style="display: none;"></span>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let infoPagina = document.getElementById('infoPagina');
            infoPagina.innerHTML = 'Pedidos';
            let infoGeneral = document.getElementById('infoGeneralText');
            infoGeneral.innerHTML = "Página de inicio. No hay mensajes.";

            // Agregar evento para buscar clientes
            var entrada_cliente = document.getElementById('cadena_cliente');
            entrada_cliente.addEventListener("keyup", function() {
                consultarBaseDatos('GET', 'scripts/cargar_cliente.php?cadena=' + encodeURIComponent(entrada_cliente.value), document.getElementById('respuesta_cliente'));
            });

            // Agregar evento para buscar productos
            var entrada_producto = document.getElementById('entrada_producto');
            entrada_producto.addEventListener("keyup", function() {
                consultarBaseDatos('GET', 'scripts/pedidos_consulta_articulo.php?cadena=' + encodeURIComponent(entrada_producto.value), document.getElementById('respuesta_producto'));
            });

            // Definición de la función selectedCliente
            window.selectedCliente = function(cliente_id, descuento) {
                var cliente_nombre = document.getElementById('nombre_cliente');
                var div_nombre_cliente = document.getElementById('cliente_seleccionado_nombre');
                div_nombre_cliente.innerHTML = cliente_nombre.innerHTML; // Mostrar el nombre del cliente
                document.getElementById('quitar_cliente').style.display = 'inline'; // Mostrar el botón de quitar

                var clienteIdElement = document.getElementById('cliente_id');
                if (clienteIdElement) {
                    clienteIdElement.value = cliente_id; // Almacenar el ID del cliente
                }

                // Almacenar el descuento en el campo oculto
                var clienteDescuentoElement = document.getElementById('cliente_descuento');
                if (clienteDescuentoElement) {
                    clienteDescuentoElement.value = descuento; // Almacenar el descuento
                } else {
                    console.error("Elemento con ID 'cliente_descuento' no encontrado.");
                }
            }

            // Definición de la función quitarCliente
            window.quitarCliente = function() {
                document.getElementById('cliente_seleccionado_nombre').innerHTML = ''; // Limpiar el nombre del cliente
                document.getElementById('quitar_cliente').style.display = 'none'; // Ocultar el botón de quitar
                document.getElementById('cliente_id').value = ''; // Limpiar el ID del cliente
            }

            // Definición de la función agregarAlPedido
            window.agregarAlPedido = function(id_producto) {
                let con_js = new XMLHttpRequest();
                con_js.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Agregar el producto al carrito
                        document.getElementById('carrito-body').insertAdjacentHTML('beforeend', this.responseText);
                        calcularSubtotal(); // Llama a la función para calcular el subtotal
                    }
                }
                con_js.open('GET', 'scripts/pedidos_articulo_selected.php?producto=' + id_producto, true);
                con_js.send();
            }

            // Definición de la función calcularSubtotal
            var calcularSubtotal = function() {
                let carrito = 0;
                let precio_unit = document.getElementsByClassName('precio');
                let descuentoPorcentaje = parseFloat(document.getElementById('cliente_descuento').value) || 0; // Obtener el descuento del cliente
                let descuentoTotal = 0;

                // Sumar los precios
                for (let i = 0; i < precio_unit.length; i++) {
                    // Convertir el precio a número, asegurándose de que no sea NaN
                    let precio = parseFloat(precio_unit[i].innerHTML.replace(/[^0-9.-]+/g, "")); // Eliminar cualquier carácter no numérico
                    if (!isNaN(precio)) {
                        carrito += precio; // Solo sumar si es un número válido
                    }
                }

                // Calcular el descuento
                descuentoTotal = (carrito * descuentoPorcentaje) / 100;
                let total = carrito - descuentoTotal;

                // Actualizar los campos de subtotal, descuento y total
                document.getElementById('subtotal').innerHTML = '$ ' + carrito.toFixed(2);
                document.getElementById('descuento').innerHTML = '$ ' + descuentoTotal.toFixed(2);
                document.getElementById('total').innerHTML = '$ ' + total.toFixed(2);
            };

            // Def ```php
            // Definición de la función removerProducto
            window.removerProducto = function(id_producto) {
                console.log("Intentando eliminar el producto con ID: " + id_producto);
                let item = document.getElementById('producto_' + id_producto);
                if (item) {
                    item.remove(); // Eliminar el elemento del carrito
                    calcularSubtotal(); // Actualizar el subtotal
                } else {
                    console.error("No se encontró el producto con ID: " + id_producto);
                }
            }

            // Agregar evento para guardar el pedido
            document.getElementById('guardar_pedido').addEventListener('click', function() {
                let cliente_id = document.getElementById('cliente_id').value;
                if (cliente_id === '') {
                    alert('Por favor, selecciona un cliente antes de guardar el pedido.');
                    return;
                }
                let articulos = [];
                document.querySelectorAll('.producto-item').forEach(function(articulo) {
                    let id_producto = articulo.getAttribute('data-id'); // Obtener el ID del producto desde el atributo data-id
                    let cantidad = parseInt(articulo.querySelector('.cantidad span').innerText) || 0;
                    articulos.push({
                        id: id_producto,
                        cantidad: cantidad
                    });
                });

                // Crear FormData para enviar los datos
                let formData = new FormData();
                formData.append('cliente_id', cliente_id);
                formData.append('articulos', JSON.stringify(articulos));

                // Enviar los datos al servidor
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'scripts/guardar_pedido.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            console.log(xhr.responseText, alert(xhr.responseText));
                        } else {
                            console.error('Error en la solicitud');
                            alert('Error al guardar el pedido');
                        }
                    }
                };
                xhr.send(formData);
            });

            // Definición de la función cambiarEstadoEntregado
            window.cambiarEstadoEntregado = function(id_pedido) {
                if (confirm("¿Estás seguro de que deseas marcar este pedido como entregado?")) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "scripts/cambiar_estado_entregado.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert(xhr.responseText); // Muestra el mensaje de éxito o error
                            location.reload(); // Recargar la página para ver el cambio
                        }
                    };
                    xhr.send("id_pedido=" + id_pedido);
                }
            }
        });
    </script>
</body>

</html>
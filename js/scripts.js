/**
 * Variable global para almacenar el subtotal de operaciones
 * @type {number}
 */
var subtotal = 0;

/**
 * Alterna la visibilidad de un elemento en la interfaz
 * 
 * @param {HTMLElement} elemento - Elemento a mostrar u ocultar
 * @param {number} [tiempo=0] - Tiempo de transición
 */
function alternarVisibilidad(elemento, tiempo = 0) {
    // Obtener estilos computados del elemento
    let estiloElemento = window.getComputedStyle(elemento);
    
    // Verificar propiedades de visibilidad
    let visibilidadDisplay = estiloElemento.getPropertyValue('display');
    let visibilidadEstilo = elemento.style.visibility;
    let displayEstilo = elemento.style.display;

    // Comprobar si el elemento está oculto
    if (visibilidadDisplay === 'none' || 
        visibilidadEstilo === 'hidden' || 
        displayEstilo === 'none') {
        
        mostrar(elemento);
        return;
    }
    
    // Comprobar si el elemento está visible
    else if (visibilidadDisplay === 'block' || 
             visibilidadEstilo === 'visible' || 
             displayEstilo === 'block') {
        
        ocultar(elemento);
    }

    /**
     * Oculta un elemento con transición
     * 
     * @param {HTMLElement} elemento - Elemento a ocultar
     */
    function ocultar(elemento) {
        // Usar setTimeout para transición suave
        setTimeout(function() {
            elemento.style.display = "none";
        }, tiempo);
    }

    /**
     * Muestra un elemento con transición
     * 
     * @param {HTMLElement} elemento - Elemento a mostrar
     */
    function mostrar(elemento) {
        // Usar setTimeout para transición suave
        setTimeout(function() {
            elemento.style.display = "block";
        }, tiempo);
    }
}

/**
 * Realiza una consulta a la base de datos de forma asíncrona
 * 
 * @param {string} peticion - Tipo de solicitud (GET, POST)
 * @param {string} url - URL del script de consulta
 * @param {HTMLElement} [elemento=null] - Elemento para mostrar respuesta
 */
var consultarBaseDatos = function (peticion, url, elemento = null) {
    // Crear solicitud AJAX
    var conexionAjax = new XMLHttpRequest();
    
    // Configurar manejador de cambio de estado
    conexionAjax.onreadystatechange = function() {
        // Verificar si la solicitud está completa y fue exitosa
        if (this.readyState == 4 && this.status == 200) {
            // Actualizar elemento si se proporcionó
            if (elemento != null) {
                elemento.innerHTML = this.responseText;
            }
        }
    };
    
    // Abrir y enviar solicitud
    conexionAjax.open(peticion, url, true);
    conexionAjax.send();
};
function borrarProducto(id_producto) {
    // Confirmar si el usuario realmente quiere borrar el producto
    if (confirm("¿Estás seguro de que deseas borrar este producto?")) {
        // Realizar la solicitud AJAX para borrar el producto
        var conexionAjax = new XMLHttpRequest();
        conexionAjax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText); // Mostrar mensaje de éxito o error
                // Opcional: actualizar la lista de productos o eliminar el elemento de la tabla
                // Aquí puedes agregar lógica para actualizar la interfaz
            }
        };
        conexionAjax.open('GET', 'scripts/borrar_producto.php?id_producto=' + id_producto, true);
        conexionAjax.send();
    }
}
function buscarClientes() {
    const buscar = document.getElementById('cadena').value;
    window.location.href = 'clientes.php?cadena=' + encodeURIComponent(buscar);
}

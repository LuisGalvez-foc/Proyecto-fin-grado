<?php
include('config.php');

$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conectado a la base de datos: " . BD . '<br>';
}

// Crear tabla usuarios
$tabla_usuarios = "CREATE TABLE IF NOT EXISTS usuarios(
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(40) NOT NULL,
    nick VARCHAR(40) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol TINYINT DEFAULT 1 COMMENT '1: Trabajador, 2: Administrador'
) ENGINE = InnoDB DEFAULT CHARSET = utf8;";

// Crear tabla productos
$tabla_productos = "CREATE TABLE IF NOT EXISTS productos(
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    precio DECIMAL(10,2) DEFAULT NULL,
    descripcion VARCHAR(80) NOT NULL,
    color VARCHAR(30) NOT NULL,
    cantidad INT DEFAULT 0,
    talle VARCHAR(8) DEFAULT NULL,
    imagen VARCHAR(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;";

// Crear tabla clientes
$tabla_clientes = "CREATE TABLE IF NOT EXISTS clientes(
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(80) NOT NULL UNIQUE,
    direccion VARCHAR(200) DEFAULT NULL,
    ciudad VARCHAR(100) DEFAULT NULL,
    provincia VARCHAR(30) DEFAULT NULL,
    codigo_postal INT DEFAULT 0000,
    email VARCHAR(150) DEFAULT NULL,
    telefono BIGINT DEFAULT NULL,
    dni INT DEFAULT NULL,
    revendedora BOOLEAN DEFAULT 0,
    descuento INT DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8;";

// Crear tabla ventas
$tabla_ventas = "CREATE TABLE IF NOT EXISTS ventas (
    id_venta INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_cliente) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// Crear tabla ventas_articulos
$tabla_ventas_articulos = "CREATE TABLE IF NOT EXISTS ventas_articulos (
    id_venta_articulo INT PRIMARY KEY AUTO_INCREMENT,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// Crear tabla pedido
$tabla_pedido = "CREATE TABLE IF NOT EXISTS pedido(
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    fecha TIMESTAMP DEFAULT current_timestamp(),
    id_usuario INT NOT NULL,
    pagado_total INT DEFAULT 0,
    fecha_entrega VARCHAR(15) DEFAULT NULL,
    entregado VARCHAR(10) DEFAULT NULL,
    importe_total DECIMAL(10,2) NOT NULL,
    saldo DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;";

// Crear tabla pedido_lista
$tabla_pedido_lista = "CREATE TABLE IF NOT EXISTS pedido_lista(
    id_pedido_lista INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;";

// Tabla para estadísticas de ventas
$tabla_estadisticas_ventas = "CREATE TABLE IF NOT EXISTS estadisticas_ventas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    producto_id INT NOT NULL,
    fecha DATE NOT NULL,
    cantidad_vendida INT NOT NULL,
    cantidad_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// Ejecutar las consultas para crear las tablas
if ($conexion->query($tabla_usuarios)) {
    echo "Tabla usuarios creada con éxito <br>";
} else {
    echo "Tabla usuarios NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_productos)) {
    echo "Tabla productos creada con éxito <br>";
} else {
    echo "Tabla productos NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_clientes)) {
    echo "Tabla clientes creada con éxito <br>";
} else {
    echo "Tabla clientes NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_ventas)) {
    echo "Tabla ventas creada con éxito <br>";
} else {
    echo "Tabla ventas NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_ventas_articulos)) {
    echo "Tabla ventas_articulos creada con éxito <br>";
} else {
    echo "Tabla ventas_articulos NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_pedido)) {
    echo "Tabla pedido creada con éxito <br>";
} else {
    echo "Tabla pedido NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_pedido_lista)) {
    echo "Tabla pedido_lista creada con éxito <br>";
} else {
    echo "Tabla pedido_lista NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
}

if ($conexion->query($tabla_estadisticas_ventas)) {
    echo "Tabla estadisticas_ventas creada con éxito <br>";
} else {
    echo "Error creando tabla estadísticas_ventas: " . $conexion->error . '<br>';
}

// Crear trigger después de que la tabla ventas_articulos haya sido creada
$trigger_sql = "
CREATE TRIGGER registrar_estadistica_venta AFTER INSERT ON ventas_articulos
FOR EACH ROW
BEGIN
    INSERT INTO estadisticas_ventas (producto_id, fecha, cantidad_vendida, cantidad_total)
    VALUES (
        NEW.producto_id, 
        CURRENT_DATE(), 
        NEW.cantidad, 
        (NEW.cantidad * NEW.precio)
    );
END;
";

// Ejecutar la creación del trigger
if ($conexion->query($trigger_sql)) {
    echo "Trigger registrar_estadistica_venta creado con éxito <br>";
} else {
    echo "Error creando trigger: " . $conexion->error . '<br>';
}

if (mysqli_close($conexion)) {
    echo "Conexión cerrada";
}
?>
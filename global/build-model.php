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
    email VARCHAR(100) NOT NULL,  -- Nueva columna para el email
    telefono VARCHAR(15) NOT NULL, -- Nueva columna para el teléfono
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
) ENGINE = InnoDB DEFAULT CHARSET = utf8";

// Crear tabla movimientos
$tabla_movimientos = "CREATE TABLE IF NOT EXISTS movimientos (
    id_movimiento INT PRIMARY KEY AUTO_INCREMENT,
    usuario INT NOT NULL,
    producto INT NOT NULL,
    fecha DATETIME DEFAULT current_timestamp())
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

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
    descuento INT DEFAULT 0)
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

// Crear tabla categoria
$tabla_categoria = "CREATE TABLE IF NOT EXISTS categoria(
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(50) NOT NULL)
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

// Crear tabla modelo
$tabla_modelo = "CREATE TABLE IF NOT EXISTS modelo(
    id_modelo INT PRIMARY KEY AUTO_INCREMENT,
    modelo VARCHAR(60) NOT NULL,
    categoria INT NOT NULL)
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

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
    saldo DECIMAL(10,2) DEFAULT 0)
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

// Crear tabla pedido_lista
$tabla_pedido_lista = "CREATE TABLE IF NOT EXISTS pedido_lista(
    id_pedido_lista INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL)
    ENGINE = InnoDB DEFAULT CHARSET = utf8";

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

if ($conexion->query($tabla_movimientos)) {
    echo "Tabla movimientos creada con éxito <br>";
} else {
    echo "Tabla movimientos NO creada: " . $conexion->error . ' Cod: ' . $conexion->errno . '<br>';
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

// Claves foráneas
$claves_foraneas = "ALTER TABLE movimientos ADD FOREIGN KEY (usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE";
$claves_foraneas2 = "ALTER TABLE movimientos ADD FOREIGN KEY (producto) REFERENCES productos (id_producto) ON DELETE CASCADE ON UPDATE CASCADE";
$claves_foraneas3 = "ALTER TABLE pedido ADD FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente) ON DELETE CASCADE ON UPDATE CASCADE";
$claves_foraneas4 = "ALTER TABLE pedido ADD FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE";
$claves_foraneas5 = "ALTER TABLE pedido_lista ADD FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido) ON DELETE CASCADE ON UPDATE CASCADE";
$claves_foraneas6 = "ALTER TABLE pedido_lista ADD FOREIGN KEY (id_producto) REFERENCES productos (id_producto) ON DELETE CASCADE ON UPDATE CASCADE";

// Ejecutar las consultas para crear las claves foráneas
if ($conexion->query($claves_foraneas)) {
    echo "Claves foráneas creadas con éxito <br>";
} else {
    echo "Clave no creada Cod: " . $conexion->errno . '<br>';
}

if ($conexion->query($claves_foraneas2)) {
    echo "Claves foráneas 2 creadas con éxito <br>";
} else {
    echo "Clave 2 no creada Cod: " . $conexion->errno . '<br>';
}

if ($conexion->query($claves_foraneas3)) {
    echo "Claves foráneas 3 creadas con éxito <br>";
} else {
    echo "Clave 3 no creada Cod: " . $conexion->errno . '//' . $conexion->error . '<br>';
}

if ($conexion->query($claves_foraneas4)) {
    echo "Claves foráneas 4 creadas con éxito <br>";
} else {
    echo "Clave 4 no creada Cod: " . $conexion->errno . '//' . $conexion->error . '<br>';
}

if ($conexion->query($claves_foraneas5)) {
    echo "Claves foráneas 5 creadas con éxito <br>";
} else {
    echo "Clave 5 no creada Cod: " . $conexion->errno . '//' . $conexion->error . '<br>';
}

if ($conexion->query($claves_foraneas6)) {
    echo "Claves foráneas 6 creadas con éxito <br>";
} else {
    echo "Clave 6 no creada Cod: " . $conexion->errno . '//' . $conexion->error . '<br>';

}

if (mysqli_close($conexion)) {
    echo "Conexión cerrada";
}
?>
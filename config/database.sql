-- Crear base de datos
CREATE DATABASE IF NOT EXISTS gestion_stock CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_stock;

-- Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    nick VARCHAR(50) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    is_medium TINYINT(1) DEFAULT 0,
    is_visitor TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla categoria
CREATE TABLE IF NOT EXISTS categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre_producto VARCHAR(80) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT DEFAULT 0,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla movimientos
CREATE TABLE IF NOT EXISTS movimientos (
    id_movimiento INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    provincia VARCHAR(100),
    codigo_postal INT,
    telefono BIGINT,
    email VARCHAR(150),
    descuento INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla proveedores
CREATE TABLE IF NOT EXISTS proveedores (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre_proveedor VARCHAR(100) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(15),
    email VARCHAR(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla pedido
CREATE TABLE IF NOT EXISTS pedido (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT NOT NULL,
    importe_total DECIMAL(10, 2) NOT NULL,
    saldo DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla pedido_lista
CREATE TABLE IF NOT EXISTS pedido_lista (
    id_pedido_lista INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla pagos
CREATE TABLE IF NOT EXISTS pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metodo_pago VARCHAR(50),
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla inventario
CREATE TABLE IF NOT EXISTS inventario (
    id_inventario INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    ubicacion VARCHAR(100),
    cantidad INT DEFAULT 0,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

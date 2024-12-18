# Proyecto de Gestión de Stock para Tienda

Este repositorio contiene un proyecto desarrollado como parte del Proyecto Final de Grado en Desarrollo de Aplicaciones Web (DAW). El objetivo principal es crear una aplicación web que facilite la gestión del stock de una tienda, utilizando PHP puro para el backend y MySQL como base de datos.

## Características Principales
- **Gestión de Productos:** Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para productos.
- **Gestión de Categorías:** Clasificación de productos en diferentes categorías.
- **Gestión de Usuarios y Roles:** Sistema básico de usuarios con roles (administrador, empleado).
- **Historial de Movimientos:** Registro de entradas y salidas de stock.

## Tecnologías Utilizadas
- **Backend:** PHP 
- **Base de Datos:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript (Bootstrap para diseño responsivo)
- **Control de Versiones:** Git y GitHub

## Requisitos Previos
1. **Entorno de Desarrollo:**
   - PHP 
   - Servidor web (Apache o Nginx)
   - MySQL
2. **Herramientas:**
   - [Visual Studio Code](https://code.visualstudio.com/)
   - [XAMPP](https://www.apachefriends.org/) o WAMP (para entorno local)

## Instalación
### Clonar el Repositorio

git clone https://github.com/LuisGalvez-foc/Proyecto-fin-grado.git
cd Proyecto-fin-grado


### Configurar el Entorno
1. Configura tu servidor local para apuntar al directorio del proyecto.
2. Asegúrate de tener configurado un archivo `config.php` con los detalles de conexión a la base de datos:
   
   <?php
   return [
       'db_host' => '127.0.0.1',
       'db_user' => 'usuario',
       'db_pass' => 'contraseña',
       'db_name' => 'nombre_de_tu_base_de_datos'
   ];
   

### Crear la Base de Datos
Importa el archivo `database.sql` incluido en este repositorio para crear las tablas necesarias.

### Iniciar el Proyecto
Abre el navegador y accede a tu servidor local (por ejemplo, [http://localhost/proyecto-fin-grado](http://localhost/proyecto-fin-grado)).

## Estructura del Proyecto
- **/public:** Contiene los archivos accesibles desde el navegador (index.php, estilos, scripts).
- **/app:** Contiene la lógica principal, como controladores y modelos.
- **/config:** Archivo de configuración para la base de datos.
- **/database.sql:** Archivo para la creación inicial de la base de datos.

## Funcionalidades Pendientes
- Implementación de autenticación con roles.
- Diseño e integración de reportes para el historial de movimientos de stock.
- Optimización del diseño responsivo del frontend.



**Autor:** Luis Galvez  
**Institución:** FOC Formación 



├── public/
│   ├── index.php         # Punto de entrada principal del proyecto
│   ├── assets/           # Recursos públicos (CSS, JS, imágenes)
│   │   ├── css/
│   │   │   └── styles.css
│   │   ├── js/
│   │   │   └── scripts.js
│   │   └── images/
├── app/
│   ├── controllers/      # Lógica principal (controladores)
│   │   ├── ProductController.php
│   │   ├── UserController.php
│   │   └── AuthController.php
│   ├── models/           # Representación de datos (modelos)
│   │   ├── Product.php
│   │   ├── User.php
│   │   └── Category.php
│   ├── views/            # Vistas HTML (plantillas)
│   │   ├── layouts/      # Layouts comunes (header, footer)
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── products/     # Vistas para productos
│   │   │   ├── list.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   ├── users/        # Vistas para usuarios
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   └── profile.php
├── config/
│   ├── config.php  
|   ├── conexion.php
│   ├── database.sql



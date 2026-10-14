MARKETPLACE DE GATOS FIEROS
Trabajo Práctico - Programación Avanzada (FCyT - UADER) - Tercera entrega
Integrantes: ver integrantes.txt


DE QUÉ SE TRATA
---------------
Sitio web en PHP con estructura MVC que implementa:
- Login con Google reCAPTCHA, validado con JavaScript y autenticado contra la
  base de datos (contraseñas guardadas con password_hash / password_verify).
- ABM (Alta, Baja y Modificación) de gatos, el producto del marketplace,
  persistido en MySQL/MariaDB.
- Listado con la librería DataTables (búsqueda, orden y paginación) y
  confirmación de baja con la librería SweetAlert2.
- Validación de la conexión a la base: si falla, se muestra un mensaje amigable.


REQUISITOS
----------
- XAMPP con Apache, MySQL/MariaDB y PHP 8
- Conexión a internet (captcha de Google y librerías por CDN)


CÓMO EJECUTARLO
---------------
1. Copiar la carpeta del proyecto dentro de C:\xampp\htdocs
   Por ejemplo: C:\xampp\htdocs\TP

2. Iniciar Apache y MySQL desde el panel de control de XAMPP.

3. Crear la base de datos importando config/schema.sql:
   - Desde phpMyAdmin (http://localhost/phpmyadmin): pestaña "Importar",
     elegir el archivo config/schema.sql y presionar "Importar".
   - O desde consola:
     C:\xampp\mysql\bin\mysql.exe -u root < C:\xampp\htdocs\TP\config\schema.sql
   El script crea la base "tp_pa" con las tablas "usuarios" y "gatos" y
   carga datos de ejemplo. Si la base ya existía, la borra y la vuelve a crear.

4. Verificar que exista el archivo .env en la raíz del proyecto.
   Si no está, copiar .env.example y renombrar la copia a .env.
   Por defecto se conecta a 127.0.0.1:3306 con el usuario root sin contraseña.

5. Abrir en el navegador:
   http://localhost/TP


USUARIOS DE PRUEBA
------------------
usuario: fcytuader   contraseña: programacionavanzada
usuario: admin       contraseña: admin123


ESTRUCTURA (MVC)
----------------
index.php                     Front controller: recibe ?accion=... y llama al controlador
.env / .env.example           Clave del captcha y datos de conexión a la BD
integrantes.txt               Nombre del grupo e integrantes

config/
  database.php                Conexión mysqli; lanza DatabaseException si falla
  schema.sql                  Script de creación de la base y datos de ejemplo

models/                       (Modelo) Acceso a datos con consultas preparadas
  UserModel.php               Busca y autentica usuarios
  GatoModel.php               Listar, buscar, crear, modificar, eliminar y validar gatos

controllers/                  (Controlador) Lógica de cada acción
  Controller.php              Base: render de vistas, redirecciones, mensajes, CSRF
  AuthController.php          Login (captcha + BD) y logout
  HomeController.php          Home público e inicio privado
  GatoController.php          ABM de gatos

views/                        (Vista) HTML que se muestra al usuario
  home.php, login.php, inicio.php, error_bd.php
  gatos/listado.php           Tabla con DataTables
  gatos/formulario.php        Alta y modificación
  includes/header.php         Navbar y mensajes
  includes/footer.php         Footer y scripts
  assets/js/validation.js     Validaciones JavaScript del login
  assets/js/gato-form.js      Validaciones JavaScript del formulario de gatos
  assets/js/gatos.js          Inicializa DataTables y la confirmación de baja


RUTAS
-----
index.php                          Home público
index.php?accion=login             Formulario de login
index.php?accion=inicio            Inicio privado
index.php?accion=gatos             Listado de gatos (ABM)
index.php?accion=gato_nuevo        Alta
index.php?accion=gato_editar&id=N  Modificación
index.php?accion=logout            Cerrar sesión
Las secciones privadas redirigen al login si no hay sesión iniciada.


NOTAS
-----
- La clave secreta del captcha se lee desde el .env y solo se usa en el
  servidor. La clave pública (site key) va en el HTML del login.
- El .env está listado en .gitignore para no subir las claves al repositorio.
  Al entregar por archivo comprimido, el .env sí se incluye para que el
  proyecto funcione al descomprimirlo.
- Para probar el mensaje de error de conexión: detener MySQL en XAMPP (o
  cambiar DB_PORT en el .env) y recargar cualquier página.

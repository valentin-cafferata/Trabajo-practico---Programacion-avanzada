MARKETPLACE DE GATOS FIEROS
Trabajo Práctico - Programación Avanzada (FCyT - UADER) - Tercera entrega
Integrantes: ver integrantes.txt


DE QUÉ SE TRATA
---------------
Marketplace web en PHP con estructura MVC, al estilo Facebook Marketplace:
- La portada es pública: cualquiera ve todas las publicaciones de gatos
  (foto, precio, raza, edad, sexo y ubicación), puede buscarlas, filtrarlas
  por precio y sexo, ordenarlas y abrir el detalle de cada una.
- Para publicar hay que tener una cuenta: registro e inicio de sesión con
  Google reCAPTCHA, validaciones en JavaScript y autenticación contra la base
  de datos (contraseñas guardadas con password_hash / password_verify).
- ABM (Alta, Baja y Modificación) de publicaciones con foto, persistido en
  MySQL/MariaDB. Cada usuario administra solo sus propias publicaciones.
- "Mis publicaciones" usa la librería DataTables (búsqueda, orden y
  paginación) y SweetAlert2 para confirmar antes de eliminar.
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
   carga 3 usuarios y 6 publicaciones de ejemplo. Si la base ya existía,
   la borra y la vuelve a crear.

4. Verificar que exista el archivo .env en la raíz del proyecto.
   Si no está, copiar .env.example y renombrar la copia a .env.
   Por defecto se conecta a 127.0.0.1:3306 con el usuario root sin contraseña.

5. Abrir en el navegador:
   http://localhost/TP


USUARIOS DE PRUEBA
------------------
usuario: fcytuader   contraseña: programacionavanzada
usuario: admin       contraseña: admin123
usuario: lucas       contraseña: lucas123
También se puede crear una cuenta nueva desde "Crear cuenta".


ESTRUCTURA (MVC)
----------------
index.php                     Front controller: recibe ?accion=... y llama al controlador
.env / .env.example           Clave del captcha y datos de conexión a la BD
integrantes.txt               Nombre del grupo e integrantes

config/
  database.php                Conexión mysqli; lanza DatabaseException si falla
  schema.sql                  Script de creación de la base y datos de ejemplo

models/                       (Modelo) Acceso a datos con consultas preparadas
  UserModel.php               Buscar, autenticar, crear y validar usuarios
  GatoModel.php               Buscar con filtros, listar por usuario, crear,
                              modificar, eliminar y validar publicaciones

controllers/                  (Controlador) Lógica de cada acción
  Controller.php              Base: render de vistas, redirecciones, mensajes, CSRF
  AuthController.php          Login, registro y logout
  HomeController.php          Portada pública con filtros y detalle de publicación
  GatoController.php          ABM de publicaciones (solo las propias)

helpers/
  Foto.php                    Subida, validación y borrado de fotos

views/                        (Vista) HTML que se muestra al usuario
  home.php                    Portada del marketplace (grilla + filtros)
  publicacion.php             Detalle de una publicación
  login.php, registro.php     Formularios de cuenta
  gatos/mis_publicaciones.php Tabla con DataTables
  gatos/formulario.php        Alta y modificación con foto
  error_bd.php                Mensaje amigable si falla la BD
  includes/header.php         Navbar y mensajes
  includes/footer.php         Footer y scripts
  assets/js/validation.js     Validaciones JavaScript del login
  assets/js/registro.js       Validaciones JavaScript del registro
  assets/js/gato-form.js      Validaciones JavaScript del formulario y vista previa de la foto
  assets/js/gatos.js          Inicializa DataTables y la confirmación de baja
  assets/img/gatos/           Fotos de las publicaciones de ejemplo

uploads/gatos/                Fotos subidas por los usuarios
                              (el .htaccess impide ejecutar archivos ahí)


RUTAS
-----
index.php                              Portada pública (acepta q, sexo, precio_min,
                                       precio_max y orden como filtros)
index.php?accion=publicacion&id=N      Detalle de una publicación
index.php?accion=login                 Iniciar sesión
index.php?accion=registro              Crear cuenta
index.php?accion=mis_publicaciones     Mis publicaciones (ABM)
index.php?accion=gato_nuevo            Publicar un gato
index.php?accion=gato_editar&id=N      Modificar una publicación propia
index.php?accion=logout                Cerrar sesión
Las acciones del ABM redirigen al login si no hay sesión iniciada.


NOTAS
-----
- La clave secreta del captcha se lee desde el .env y solo se usa en el
  servidor. La clave pública (site key) va en el HTML del login y el registro.
- El .env está listado en .gitignore para no subir las claves al repositorio.
  Al entregar por archivo comprimido, el .env sí se incluye para que el
  proyecto funcione al descomprimirlo.
- Las fotos se validan por su contenido real (no por la extensión), se
  aceptan JPG, PNG y WEBP de hasta 3 MB y se guardan con un nombre aleatorio.
- Para probar el mensaje de error de conexión: detener MySQL en XAMPP (o
  cambiar DB_PORT en el .env) y recargar cualquier página.

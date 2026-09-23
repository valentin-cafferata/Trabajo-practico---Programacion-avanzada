MARKETPLACE DE GATOS FIEROS
Trabajo Práctico - Programación Avanzada (FCyT - UADER)
Integrantes: ver integrantes.txt


DE QUÉ SE TRATA
---------------
Sitio web en PHP que implementa la segunda entrega del TP: un formulario de
login protegido con Google reCAPTCHA y manejo de sesiones.

Flujo del sitio:
- index.php redirige al home público (frontend/index.php).
- En el home hay un botón "Login" que lleva al formulario (frontend/login.php).
- El formulario pide usuario, contraseña y resolver el captcha.
- backend/procesoLogin.php valida el captcha contra Google y luego las
  credenciales. Si todo es correcto crea la sesión y guarda el nombre de usuario.
- frontend/inicio.php es la página privada de bienvenida. Solo se puede entrar
  con la sesión creada; si no, redirige al login.
- El header muestra el usuario logueado y un botón "Salir" (backend/logout.php),
  que destruye la sesión.


REQUISITOS
----------
- XAMPP con Apache y PHP 8
- Conexión a internet (el captcha se valida contra los servidores de Google)


CÓMO EJECUTARLO
---------------
1. Copiar la carpeta del proyecto dentro de C:\xampp\htdocs
   Por ejemplo: C:\xampp\htdocs\TP

2. Verificar que exista el archivo .env en la raíz del proyecto.
   Si no está, copiar .env.example y renombrar la copia a .env
   (el .env ya viene con la clave secreta del captcha cargada).

3. Iniciar Apache desde el panel de control de XAMPP.

4. Abrir en el navegador:
   http://localhost/TP


USUARIO DE PRUEBA
-----------------
usuario:    fcytuader
contraseña: programacionavanzada


ESTRUCTURA
----------
index.php                     Redirige al home público
.env                          Clave secreta del captcha y credenciales
.env.example                  Plantilla del .env
integrantes.txt               Integrantes del grupo

frontend/
  index.php                   Home público
  login.php                   Formulario de login con captcha
  inicio.php                  Página privada de bienvenida
  includes/header.php         Header (navbar y usuario logueado)
  includes/footer.php         Footer
  assets/css/                 Estilos
  assets/js/validation.js     Valida campos y captcha antes de enviar
  assets/js/alertas.js        Limpia el mensaje de error de la URL
  assets/img/                 Imágenes

backend/
  procesoLogin.php            Valida captcha y credenciales, crea la sesión
  logout.php                  Cierra la sesión


NOTAS
-----
- La clave secreta del captcha se lee desde el .env y solo se usa en el
  servidor. La clave pública (site key) va en el HTML del login, porque el
  widget de reCAPTCHA la necesita en el navegador.
- El .env está listado en .gitignore para no subir las claves al repositorio.
  Al entregar por archivo comprimido, el .env sí se incluye para que el
  proyecto funcione al descomprimirlo.

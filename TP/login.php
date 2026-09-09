<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet">
  <link href="css/navbar.css" rel="stylesheet">
  
  <style>
      body {
        /* Reemplaza con la ruta real de tu imagen */
        background-image: url('img/Maxwell-2.jpg'); 
        background-repeat: repeat;
        background-position: 0 0;
        
        /* 40s define la duración. Auméntalo para que sea más lento */
        animation: moverFondo 40s linear infinite; 
      }

      @keyframes moverFondo {
        from {
          background-position: 0 0;
        }
        to {
          /* Mueve el fondo hacia la izquierda. 
            Para que el reinicio no se note, el valor en px (1000px) debe coincidir con el ancho de tu imagen. */
          background-position: -1000px 0; 
        }
      }
    </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="img/logo.png" alt="Logo Marketplace" width="50" height="50" class="d-inline-block align-text-top">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active border border-light rounded px-3 text-white" aria-current="page" href="index.php">Home</a>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>


  <!-- Contenedor para centrar la caja en toda la pantalla (vh-100) y dar color de fondo -->
  <div class="d-flex justify-content-center align-items-center vh-100">

    <!-- Caja del Login (Card con sombra y bordes redondeados) -->
    <div class="card shadow-sm border-0 p-4 rounded-4" style="max-width: 420px; width: 100%;">
      
      <!-- Textos de encabezado centrados -->
      <div class="text-center mb-4">
        <h5 class="text-primary fw-bold">Marketplace de Gatitos</h5>
        <h3 class="fw-bold">Bienvenido de nuevo</h3>
        <p class="text-muted">Ingresa tus datos para continuar</p>
      </div>

      <form id="miForm" action="procesoLogin.php" method="POST">
        <div id="alerta-contenedor"></div>
        
        <!-- Inputs con form-control-lg para hacerlos más grandes y placeholder en lugar de label -->
        <div class="mb-3">
          <input type="text" class="form-control form-control-lg rounded-3" id="usuario" name="usuario" placeholder="Usuario">
        </div>

        <div class="mb-3">
          <input type="password" class="form-control form-control-lg rounded-3" id="password" name="password" placeholder="Contraseña">
        </div>

        <!-- Botones estilizados para ocupar todo el ancho (w-100) -->
        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg w-100 rounded-3 mb-2" style="bg-primary; border: none;" disabled>Ingresar</button> 
        
        <!-- <button type="button" class="btn btn-outline-primary btn-lg w-100 rounded-3">Regístrate</button> -->
      </form>
    </div>
  </div>


  <script src="js/validation.js?v=2"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
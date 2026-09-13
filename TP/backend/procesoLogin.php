<?php
// Validar que el token del captcha fue enviado
if (isset($_POST['g-recaptcha-response'])) {
    $secret = '6LeRirktAAAAAN8Ybo_AbH7emq7LdJuDA2eg9u2H';
    $captcha = $_POST['g-recaptcha-response'];
    
    // Enviar la consulta a Google
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    $result = json_decode($response, true);
    
    // Verificar si falló
    if ($result['success'] != 1) {
        header('Location: ../frontend/login.php');
        exit();
    }
    
    // Si llega aquí, el CAPTCHA es válido y puedes continuar con el login normal.
    // ... [tu código de validación de base de datos] ...

} else {
    header('Location: ../frontend/login.php');
    exit();
}
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/login.php');
    exit();
}

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($usuario !== 'fcytuader' || $password !== 'programacionavanzada') {
    header('Location: ../frontend/login.php?error=1');
    exit();
}

$_SESSION['usuario'] = $usuario;
$tituloPagina = 'Ingreso';
require_once __DIR__ . '/../frontend/includes/header.php';
?>
  <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 140px);">
    <div class="card shadow-sm border-0 p-4 rounded-4 text-center" style="max-width: 420px; width: 100%;">
      <div class="alert alert-success mb-3">ingreso correctamente</div>
      <a class="btn btn-primary" href="../frontend/index.php">Ir al inicio</a>
    </div>
  </div>
<?php require_once __DIR__ . '/../frontend/includes/footer.php'; ?>

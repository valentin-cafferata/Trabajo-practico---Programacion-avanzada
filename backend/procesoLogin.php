<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/login.php');
    exit();
}

$usuario = trim($_POST['usuario'] ?? '');
$password = trim($_POST['password'] ?? '');
$captcha = $_POST['g-recaptcha-response'] ?? '';

if (empty($captcha)) {
    header('Location: ../frontend/login.php?captcha_error=1');
    exit();
}

// Leer el archivo .env
$env = parse_ini_file(__DIR__ . '/../.env');
$secret = $env['RECAPTCHA_SECRET'];

$response = file_get_contents(
    'https://www.google.com/recaptcha/api/siteverify?secret=' .
    urlencode($secret) .
    '&response=' .
    urlencode($captcha)
);

$resultadoCaptcha = json_decode($response, true);

// Verificar la respuesta de Google
if (empty($resultadoCaptcha['success'])) {
    header('Location: ../frontend/login.php?captcha_error=1');
    exit();
}

// Verificar usuario y contraseña
if (
    $usuario !== $env['USUARIO_ADMIN'] ||
    $password !== $env['PASS_ADMIN']
) {
    header('Location: ../frontend/login.php?error=1');
    exit();
}

// Ingreso correcto
$_SESSION['usuario'] = $usuario;
$tituloPagina = 'Ingreso';

require_once __DIR__ . '/../frontend/includes/header.php';
?>

<div class="d-flex justify-content-center align-items-center"
     style="min-height: calc(100vh - 140px);">

    <div class="card shadow-sm border-0 p-4 rounded-4 text-center"
         style="max-width: 420px; width: 100%;">

        <div class="alert alert-success mb-3">
            Ingreso correctamente
        </div>

        <a class="btn btn-primary" href="../frontend/inicio.php">
            Ir al inicio
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../frontend/includes/footer.php'; ?>
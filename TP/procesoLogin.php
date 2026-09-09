<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($usuario === 'fcytuader' && $password === 'pa') {
    $_SESSION['usuario'] = $usuario;
    header('Location: index.php');
    exit();
}

header('Location: login.php?error=1');
exit();

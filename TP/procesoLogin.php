<?php
session_start(); // Debe ir en la primera línea

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if ($usuario === "fcytuader" && $password === "pa") {
        $_SESSION['usuario'] = $usuario; // Guardamos el nombre en la sesión
        
        echo "Ingreso correctamente. Redirigiendo...";
        header("refresh:2; url=index.php"); 
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
        header("refresh:2; url=login.php");
        exit();
    }
}
?>
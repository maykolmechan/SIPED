<?php
// Simulación de autenticación básica, reemplázalo con tu lógica de autenticación real.
$usuario_valido = "ADMIN";
$contrasena_valida = "contra";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    if ($usuario == $usuario_valido && $contrasena == $contrasena_valida) {
        // Inicia sesión y redirecciona al sistema.php
        session_start();
        $_SESSION["usuario"] = $usuario;
        header("Location: ./vistas/sistema.php");
        exit();
    } else {
        // Autenticación fallida, redirecciona a la página de inicio de sesión.
        header("Location: index.php?av=1");
        exit();
    }
}
?>

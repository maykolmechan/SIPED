<?php
session_start();

// Verifica si la sesión está iniciada, de lo contrario redirecciona a la página de inicio de sesión.
if (isset($_SESSION["usuario"])) {
    header("Location: ./Vista/sistema.php");
    exit();
}
if (isset($_GET['av'])) {
            $av = intval($_GET['av']);
            if ($av == 1) {
                echo '<div class="alert alert-danger" role="alert">*Datos de inicio incorrectos</div><br>';
            } elseif ($av == 3) {
                echo '<div class="alert alert-success" role="alert">Cerró sesión correctamente</div>';
            }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(white, black);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: red;
            border: none;
        }
        .btn-primary:hover {
            background-color: blue;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center" style="color: black;">SISTEMA DE INFORMACIÓN DEL OMAPED</h2>
        <h3 class="text-center" style="color: black;">Iniciar Sesión</h3>
        <form action="procesar_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</body>
</html>

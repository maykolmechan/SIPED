<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */
class ControladorLogin {
    public function autenticar($usuario, $contrasena) {
        $usuario_valido = "ADMIN";
        $contrasena_valida = "contra";

        if ($usuario == $usuario_valido && $contrasena == $contrasena_valida) {
            session_start();
            $_SESSION["usuario"] = $usuario;
            header("Location: vistas/sistema.php");
        } else {
            header("Location: index.php?error=1");
        }
    }
}
?>

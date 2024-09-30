<?php
session_start();
unset ($SESSION['usuario']);
session_destroy(); // Destruye todas las variables de sesión.
header("Location: index.php?av=3");
exit();
?>
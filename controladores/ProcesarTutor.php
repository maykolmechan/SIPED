<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */

session_start();

require_once '../controladores/ControladorTutor.php';

$controladorTutor = new ControladorTutor();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $datosTutor = [
        'nombre' => htmlspecialchars(trim($_POST['nombre'])),
        'dni' => htmlspecialchars(trim($_POST['dni'])),
        'sexo' => htmlspecialchars(trim($_POST['sexo'])),
        'celular' => htmlspecialchars(trim($_POST['celular'])),
        'parentezco' => htmlspecialchars(trim($_POST['parentezco'])),
        'direccion_actual' => htmlspecialchars(trim($_POST['direccion_actual'])),
        'persona_discapacidad_id' => intval($_POST['persona_discapacidad_id'])
    ];    
        // Agregar nuevo tutor
        $controladorTutor->agregarTutor($datosTutor);
        header("Location: ../vistas/sistema.php?av=4"); // Agregado exitoso de tutor
        exit();
} else {
    // Redirigir si no se recibe un POST
    header("Location: ../vistas/sistema.php?av=0");
    exit();
}
?>

<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */
session_start();

require_once '../controladores/ControladorPersona.php';

$controladorPersona = new ControladorPersona();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $datosPersona = [
        'nombre_apellido' => $_POST['nombre_apellido'],
        'dni' => $_POST['dni'],
        'sexo' => $_POST['sexo'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'seguro' => $_POST['seguro'],
        'estado_civil' => $_POST['estado_civil'],
        'celular' => $_POST['celular'],
        'direccion' => $_POST['direccion'],
        'tipo_discapacidad' => $_POST['tipo_discapacidad'],
        'grado_instruccion' => $_POST['grado_instruccion'],
        'nivel_socioeconomico' => $_POST['nivel_socioeconomico'],
        'actualmente_trabaja' => $_POST['actualmente_trabaja'],
        'lugar_trabajo' => $_POST['lugar_trabajo'],
        'tiene_carnet_discapacidad' => $_POST['tiene_carnet_discapacidad'],
        'numero_carnet' => $_POST['numero_carnet'],
        'tipo_discapacidad_carnet' => $_POST['tipo_discapacidad_carnet'],
    ];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Si existe un ID, se está editando
        $controladorPersona->editarPersona($_POST['id'], $datosPersona);
        header("Location: ../vistas/sistema.php?av=1");
    } else {
        // Si no existe un ID, se está agregando
        $controladorPersona->agregarPersona($datosPersona);
        header("Location: ../vistas/sistema.php?av=2");
    }
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'eliminar') {
    // Manejo de eliminación
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $controladorPersona->eliminarPersona($_GET['id']);
        header("Location: ../vistas/sistema.php?av=2");
        exit();
    }
}

?>

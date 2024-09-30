<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}

require_once '../controladores/ControladorTutor.php';

$controladorTutor = new ControladorTutor();
$tutor = null;
$personaId = isset($_GET['id']) ? $_GET['id'] : null;

if (isset($_GET['id'])) {
    $tutor = $controladorTutor->obtenerTutorPorId($_GET['id'])[0];
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .form-container {           
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?= $tutor ? 'Editar Tutor' : 'Agregar Tutor' ?></h1>
        <div class="form-container">
            <form action="../controladores/ProcesarTutor2.php" method="POST">
                <input type="hidden" name="id" value="<?= $tutor ? $tutor['id'] : '' ?>">
                <input type="hidden" name="persona_discapacidad_id" value="<?= $personaId ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?= $tutor ? $tutor['nombre'] : '' ?>" required maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" name="dni" value="<?= $tutor ? $tutor['dni'] : '' ?>" maxlength="9" required>
                </div>

                <div class="mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" name="sexo" required>
                        <option value="MASCULINO" <?= $tutor && $tutor['sexo'] == 'MASCULINO' ? 'selected' : '' ?>>Masculino</option>
                        <option value="FEMENINO" <?= $tutor && $tutor['sexo'] == 'FEMENINO' ? 'selected' : '' ?>>Femenino</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" name="celular" value="<?= $tutor ? $tutor['celular'] : '' ?>" maxlength="9" required>
                </div>

                <div class="mb-3">
                    <label for="parentezco" class="form-label">Parentesco</label>
                    <select class="form-select" name="parentezco" required>
                        <option value="PADRE" <?= $tutor && $tutor['parentezco'] == 'PADRE' ? 'selected' : '' ?>>Padre</option>
                        <option value="MADRE" <?= $tutor && $tutor['parentezco'] == 'MADRE' ? 'selected' : '' ?>>Madre</option>
                        <option value="HIJO(A)" <?= $tutor && $tutor['parentezco'] == 'HIJO(A)' ? 'selected' : '' ?>>Hijo(a)</option>
                        <option value="HERMANO(A)" <?= $tutor && $tutor['parentezco'] == 'HERMANO(A)' ? 'selected' : '' ?>>Hermano(a)</option>
                        <option value="TIO(A)" <?= $tutor && $tutor['parentezco'] == 'TIO(A)' ? 'selected' : '' ?>>Tío(a)</option>
                        <option value="CUÑADO(A)" <?= $tutor && $tutor['parentezco'] == 'CUÑADO(A)' ? 'selected' : '' ?>>Cuñado(a)</option>
                        <option value="ESPOSO(A)" <?= $tutor && $tutor['parentezco'] == 'ESPOSO(A)' ? 'selected' : '' ?>>Esposo(a)</option>
                        <option value="CONVIVIENTE" <?= $tutor && $tutor['parentezco'] == 'CONVIVIENTE' ? 'selected' : '' ?>>Conviviente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="direccion_actual" class="form-label">Dirección Actual</label>
                    <input type="text" class="form-control" name="direccion_actual" value="<?= $tutor ? $tutor['direccion_actual'] : '' ?>" required maxlength="150">
                </div>

                <button type="submit" class="btn btn-primary"><?= $tutor ? 'Actualizar' : 'Guardar' ?></button>
                <a href="sistema.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

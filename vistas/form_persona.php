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

require_once '../controladores/ControladorPersona.php';

$controladorPersona = new ControladorPersona();
$persona = null;

if (isset($_GET['id'])) {
    $persona = $controladorPersona->obtenerPersonaPorId($_GET['id'])[0];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Persona</title>
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
        <h1 class="text-center"><?= $persona ? 'Editar Persona' : 'Agregar Persona' ?></h1>
        <div class="form-container">
            <form action="../controladores/ProcesarPersona.php" method="POST">
                <input type="hidden" name="id" value="<?= $persona ? $persona['id'] : '' ?>">

                <div class="mb-3">
                    <label for="nombre_apellido" class="form-label">Nombre y Apellido</label>
                    <input type="text" class="form-control" name="nombre_apellido" value="<?= $persona ? $persona['nombre_apellido'] : '' ?>" required maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" name="dni" value="<?= $persona ? $persona['dni'] : '' ?>" maxlength="8" required>
                </div>

                <div class="mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" name="sexo" required>
                        <option value="MASCULINO" <?= $persona && $persona['sexo'] == 'MASCULINO' ? 'selected' : '' ?>>Masculino</option>
                        <option value="FEMENINO" <?= $persona && $persona['sexo'] == 'FEMENINO' ? 'selected' : '' ?>>Femenino</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" value="<?= $persona ? $persona['fecha_nacimiento'] : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="seguro" class="form-label">Seguro</label>
                    <select class="form-select" name="seguro" required>
                        <option value="SIS" <?= $persona && $persona['seguro'] == 'SIS' ? 'selected' : '' ?>>SIS</option>
                        <option value="ESSALUD" <?= $persona && $persona['seguro'] == 'ESSALUD' ? 'selected' : '' ?>>ESSALUD</option>
                        <option value="FALLECIDO" <?= $persona && $persona['seguro'] == 'FALLECIDO' ? 'selected' : '' ?>>FALLECIDO</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado_civil" class="form-label">Estado Civil</label>
                    <select class="form-select" name="estado_civil" required>
                        <option value="SOLTERO(A)" <?= $persona && $persona['estado_civil'] == 'SOLTERO(A)' ? 'selected' : '' ?>>Soltero(a)</option>
                        <option value="CASADO(A)" <?= $persona && $persona['estado_civil'] == 'CASADO(A)' ? 'selected' : '' ?>>Casado(a)</option>
                        <option value="VIUDO(A)" <?= $persona && $persona['estado_civil'] == 'VIUDO(A)' ? 'selected' : '' ?>>Viudo(a)</option>
                        <option value="DIVORCIADO(A)" <?= $persona && $persona['estado_civil'] == 'DIVORCIADO(A)' ? 'selected' : '' ?>>Divorciado(a)</option>
                        <option value="CONVIVIENTE" <?= $persona && $persona['estado_civil'] == 'CONVIVIENTE' ? 'selected' : '' ?>>Conviviente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" name="celular" value="<?= $persona ? $persona['celular'] : '' ?>" maxlength="9" required>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" value="<?= $persona ? $persona['direccion'] : '' ?>" required maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="tipo_discapacidad" class="form-label">Tipo de Discapacidad</label>
                    <input type="text" class="form-control" name="tipo_discapacidad" value="<?= $persona ? $persona['tipo_discapacidad'] : '' ?>" maxlength="120" required>
                </div>

                <div class="mb-3">
                    <label for="grado_instruccion" class="form-label">Grado de Instrucción</label>
                    <select class="form-select" name="grado_instruccion" required>
                        <option value="INICIAL" <?= $persona && $persona['grado_instruccion'] == 'INICIAL' ? 'selected' : '' ?>>Inicial</option>
                        <option value="PRIMARIA" <?= $persona && $persona['grado_instruccion'] == 'PRIMARIA' ? 'selected' : '' ?>>Primaria</option>
                        <option value="SECUNDARIA" <?= $persona && $persona['grado_instruccion'] == 'SECUNDARIA' ? 'selected' : '' ?>>Secundaria</option>
                        <option value="TÉCNICA" <?= $persona && $persona['grado_instruccion'] == 'TÉCNICA' ? 'selected' : '' ?>>Técnica</option>
                        <option value="UNIVERSITARIA" <?= $persona && $persona['grado_instruccion'] == 'UNIVERSITARIA' ? 'selected' : '' ?>>Universitaria</option>
                        <option value="MAESTRÍA" <?= $persona && $persona['grado_instruccion'] == 'MAESTRÍA' ? 'selected' : '' ?>>Maestría</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nivel_socioeconomico" class="form-label">Nivel Socioeconómico</label>
                    <select class="form-select" name="nivel_socioeconomico" required>
                        <option value="NO POBRE" <?= $persona && $persona['nivel_socioeconomico'] == 'NO POBRE' ? 'selected' : '' ?>>No Pobre</option>
                        <option value="POBRE" <?= $persona && $persona['nivel_socioeconomico'] == 'POBRE' ? 'selected' : '' ?>>Pobre</option>
                        <option value="POBRE EXTREMO" <?= $persona && $persona['nivel_socioeconomico'] == 'POBRE EXTREMO' ? 'selected' : '' ?>>Pobre Extremo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="actualmente_trabaja" class="form-label">Actualmente Trabaja</label>
                    <select class="form-select" name="actualmente_trabaja" required>
                        <option value="SI" <?= $persona && $persona['actualmente_trabaja'] == 'SI' ? 'selected' : '' ?>>Sí</option>
                        <option value="NO" <?= $persona && $persona['actualmente_trabaja'] == 'NO' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lugar_trabajo" class="form-label">Lugar de Trabajo</label>
                    <input type="text" class="form-control" name="lugar_trabajo" value="<?= $persona ? $persona['lugar_trabajo'] : '' ?>" maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="tiene_carnet_discapacidad" class="form-label">¿Tiene Carnet de Discapacidad?</label>
                    <select class="form-select" name="tiene_carnet_discapacidad" required>
                        <option value="SI" <?= $persona && $persona['tiene_carnet_discapacidad'] == 'SI' ? 'selected' : '' ?>>Sí</option>
                        <option value="NO" <?= $persona && $persona['tiene_carnet_discapacidad'] == 'NO' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="numero_carnet" class="form-label">Número de Carnet</label>
                    <input type="text" class="form-control" name="numero_carnet" value="<?= $persona ? $persona['numero_carnet'] : '' ?>" maxlength="10">
                </div>

                <div class="mb-3">
                    <label for="tipo_discapacidad_carnet" class="form-label">Tipo de Discapacidad (Carnet)</label>
                    <select class="form-select" name="tipo_discapacidad_carnet">
                        <option value="LEVE" <?= $persona && $persona['tipo_discapacidad_carnet'] == 'LEVE' ? 'selected' : '' ?>>Leve</option>
                        <option value="MODERADA" <?= $persona && $persona['tipo_discapacidad_carnet'] == 'MODERADA' ? 'selected' : '' ?>>Moderada</option>
                        <option value="SEVERA" <?= $persona && $persona['tipo_discapacidad_carnet'] == 'SEVERA' ? 'selected' : '' ?>>Severa</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><?= $persona ? 'Actualizar' : 'Guardar' ?></button>
                <a href="sistema.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

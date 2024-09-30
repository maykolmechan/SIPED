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

// Recibir el valor del parámetro 'tipo' a través del método GET
$nivel_socioeconomico = isset($_GET['tipo']) ? $_GET['tipo'] : 'Desconocido';

// Mostrar el título basado en el nivel socioeconómico
$titulo = "Reporte por personas con discapacidad $nivel_socioeconomico";

if (isset($_GET['av'])) {
    $av = intval($_GET['av']);
    if ($av == 0) {
        echo '<div class="alert alert-danger" role="alert">*Error</div><br>';
    } 
    if ($av == 2) {
        echo '<div class="alert alert-success" role="alert">*Agregado</div><br>';
    } elseif ($av == 1) {
        echo '<div class="alert alert-success" role="alert">Actualizado</div><br>';
    }
    if ($av == 3) {
        echo '<div class="alert alert-success" role="alert">*Tutor Actualizado</div><br>';
    } elseif ($av == 4) {
        echo '<div class="alert alert-success" role="alert">*Tutor Agregado</div><br>';
    }
}

require_once '../controladores/ControladorPersona.php';
require_once '../controladores/ControladorTutor.php';

$controladorPersona = new ControladorPersona();
$controladorTutor = new ControladorTutor();
$personas = $controladorPersona->listarPersonas();



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Personas con Discapacidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table-responsive {
            overflow-x: auto;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
        }
        .logout-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Listado de Personas con Discapacidad del OMAPED</h1>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="buscarInput" placeholder="Buscar..." onkeyup="filtrarTabla()">
        </div>

        <div class="table-responsive w-100 table-containe">
            <table class="table table-dark w-100" id="tablaDatos">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre|Dni</th>
                        <th>Fecha Nacimiento| Estado Civil</th>
                        <th>CONTACTO</th>
                        <th>Instrucción| Discapacidad| Socieconomico</th>
                        <th>TRABAJO</th>
                        <th>CARNET</th>
                        <th>Tutor</th>
                        <th>Datos</th>                        
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tablaCuerpo">
                    <?php 
                          function calcularEdad($fechaNacimiento) {
                                $fechaNac = new DateTime($fechaNacimiento);
                                $hoy = new DateTime();
                                $edad = $hoy->diff($fechaNac);
                                return $edad->y;
                          }
                          
                            $hombres = 0;
                            $mujeres = 0;
                            $ninos = 0;                            
                            
                            $nivelSocioeconomico = [
                                'NO POBRE' => 0,
                                'POBRE' => 0,
                                'POBRE EXTREMO' => 0,
                            ];

                            $tipoDiscapacidadCarnet = [
                                'LEVE' => 0,
                                'MODERADA' => 0,
                                'SEVERA' => 0,
                            ];

                          foreach ($personas as $persona) {
                            $tutors = $controladorTutor->listarTutoresPorPersona($persona['id']);
                    ?>
                    <tr>
                        <td>
                            <a href="form_persona.php?id=<?= $persona['id'] ?>" class="btn btn-primary">Editar</a>
                            <a href="../controladores/ProcesarPersona.php?action=eliminar&id=<?= $persona['id'] ?>" class="btn btn-danger" onclick="return confirmarEliminacion()">Eliminar</a>
                        </td>
                        <td><?= $persona['nombre_apellido'].'<br>DNI:'.$persona['dni']?>
                            <span style="color: <?= $persona['sexo'] == 'MASCULINO' ? 'Cyan' : 'DeepPink'; ?>;">
                                <?= $persona['sexo'] ?>
                                </span>
                        </td>
                        <?php 
                            if ($persona['sexo'] == 'MASCULINO' && calcularEdad($persona['fecha_nacimiento']) >= 18) {
                                $hombres++;
                                
                            } elseif ($persona['sexo'] == 'FEMENINO' && calcularEdad($persona['fecha_nacimiento']) >= 18) {
                                $mujeres++;
                               
                            }
                            if (calcularEdad($persona['fecha_nacimiento']) < 18) {
                                    $ninos++;
                            }
                            
                            // Contar por nivel socioeconómico
                            if (array_key_exists($persona['nivel_socioeconomico'], $nivelSocioeconomico)) {
                                $nivelSocioeconomico[$persona['nivel_socioeconomico']]++;
                            }

                            // Contar por tipo de discapacidad del carnet
                            if (array_key_exists($persona['tipo_discapacidad_carnet'], $tipoDiscapacidadCarnet)) {
                                $tipoDiscapacidadCarnet[$persona['tipo_discapacidad_carnet']]++;
                            }
                            // Calcular los porcentajes
                            //$totalPersonas = count($personas);
                            $porcentajeNivelSocioeconomico = [];
                            $porcentajeTipoDiscapacidadCarnet = [];
                            // Porcentaje de discapacidad
                            $totalPersonas = count($personas);
                                                        
                            foreach ($nivelSocioeconomico as $nivel => $cantidad) {
                                $porcentajeNivelSocioeconomico[$nivel] = ($cantidad / $totalPersonas) * 100;
                            }

                            foreach ($tipoDiscapacidadCarnet as $tipo => $cantidad) {
                                $porcentajeTipoDiscapacidadCarnet[$tipo] = ($cantidad / $totalPersonas) * 100;
                            }
                            
                        ?>
                        <td><?= $persona['fecha_nacimiento'].'<br>'.$persona['estado_civil'].'<br>'. calcularEdad($persona['fecha_nacimiento']).' años' ?></td>
                        <td><span style="color: <?= $persona['seguro'] == 'SIS' ? 'GreenYellow' : 'SteelBlue'; ?>;">
                               <?= $persona['seguro'] ?>
                            </span>
                            <?= '<br>#'.$persona['celular'].'<br>'.$persona['direccion'] ?></td>
                        <td><?= $persona['grado_instruccion'].'*<br>'.$persona['tipo_discapacidad'].'<br>NSE: '.$persona['nivel_socioeconomico'] ?></td>
                        <td><?= $persona['actualmente_trabaja'].'<br>'.$persona['lugar_trabajo'] ?></td>
                        <td><?= $persona['tiene_carnet_discapacidad'].'<br>#'.$persona['numero_carnet'].'<br>'.$persona['tipo_discapacidad_carnet'] ?></td>
                        
                            <?php if (count($tutors) > 0) {
                                  foreach ($tutors as $tutor) { ?>
                        
                        <td>      <?= 'DNI:'.$tutor['dni'].'<br>'.$tutor['parentezco'].': '.$tutor['nombre'] ?></td>
                        <td>      <span style="color: <?= $tutor['sexo'] == 'MASCULINO' ? 'Cyan' : 'DeepPink'; ?>;">
                                    <?= $tutor['sexo'] ?>
                                  </span>
                                    <?= '<br>#'.$tutor['celular'].'<br>'.$tutor['direccion_actual'] ?>
                        </td>
                            <?php } ?>
                        <td>
                            <a href="form_tutor2.php?id=<?= $tutor['id'] ?>" class="btn btn-warning">MODIFICAR Tutor</a>
                        </td>
                            <?php } else { ?>
                        <td>
                            <span style="color: red;"> No tiene tutor</span>
                            <a href="form_tutor.php?id=<?= $persona['id'] ?>" class="btn btn-warning">AGREGAR Tutor</a>
                        </td>
                        <td>-</td>
                        <td>-</td>
                            <?php } ?>
                        
                        
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="pagination-container">
            <nav aria-label="Paginación">
                <ul class="pagination" id="paginacion"></ul>
            </nav>
        </div>
        
        <!-- Botón para agregar nueva persona -->
        <div class="text-center mt-3">
            <a href="form_persona.php" class="btn btn-success">Agregar Nueva Persona</a>
        </div>

        
        <div class="container mt-5">
            <h2 class="text-center">Resumen y Estadísticas del OMAPED</h2>
            <table class="table table-dark" id="TablaEstadisticas">
                <thead>
                    <tr>
                        <th>Género</th>
                        <th>Cantidad</th>
                        <th>Nivel Socioeconómico</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                        <th>Tipo Discapacidad Carnet</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HOMBRES</td>
                        <td><?= $hombres ?></td>                        
                        <td>NO POBRE</td>
                        <td><?= $nivelSocioeconomico['NO POBRE'] ?></td>
                        <td><?= round($porcentajeNivelSocioeconomico['NO POBRE'], 2) ?>%</td>
                        <td>LEVE</td>
                        <td><?= $tipoDiscapacidadCarnet['LEVE'] ?></td>
                        <td><?= round($porcentajeTipoDiscapacidadCarnet['LEVE'], 2) ?>%</td>
                    </tr>
                    <tr>
                        <td>MUJERES</td>
                        <td><?= $mujeres ?></td>                        
                        <td>POBRE</td>
                        <td><?= $nivelSocioeconomico['POBRE'] ?></td>
                        <td><?= round($porcentajeNivelSocioeconomico['POBRE'], 2) ?>%</td>
                        <td>MODERADA</td>
                        <td><?= $tipoDiscapacidadCarnet['MODERADA'] ?></td>                        
                        <td><?= round($porcentajeTipoDiscapacidadCarnet['MODERADA'], 2) ?>%</td>
                    </tr>
                    <tr>
                        <td>NIÑ@S</td>
                        <td><?= $ninos ?></td>                        
                        <td>POBRE EXTREMO</td>
                        <td><?= $nivelSocioeconomico['POBRE EXTREMO'] ?></td>                        
                        <td><?= round($porcentajeNivelSocioeconomico['POBRE EXTREMO'], 2) ?>%</td>
                        <td>SEVERA</td>
                        <td><?= $tipoDiscapacidadCarnet['SEVERA'] ?></td>                        
                        <td><?= round($porcentajeTipoDiscapacidadCarnet['SEVERA'], 2) ?>%</td>
                    </tr>
                    <tr>
                        
                    </tr>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>TOTALES</th>
                        <th><?= $hombres + $mujeres + $ninos ?></th>
                        <th>TOTALES</th>
                        <th><?= array_sum($nivelSocioeconomico) ?></th>
                        <th>100%</th>
                        <th>TOTALES</th>
                        <th><?= array_sum($tipoDiscapacidadCarnet) ?></th>
                        <th>100%</th>                        
                    </tr>                    
                </tfoot>                
                   
            </table>
        </div>
        
        <div class="container mt-5">
            <h2 class="text-center">Gráficos de Estadísticas</h2>
            <div class="row">
                <div class="col-md-4">
                    <h4> Género</h4>
                    <canvas id="generoChart"></canvas>
                </div>
                <div class="col-md-4">
                    <h4>Nivel Socioeconómico</h4>
                    <canvas id="nivelSocioeconomicoChart"></canvas>
                </div>
                <div class="col-md-4">
                    <h4>Tipo de Discapacidad</h4>
                    <canvas id="discapacidadChart"></canvas>
                </div>                
            </div>
        </div>

                

        <!-- Botón para cerrar sesión -->
        <div class="logout-button">
            <a href="../logout.php" class="btn btn-secondary">Cerrar Sesión</a>
        </div>
        <br><br>
    </div>

    <script>
        const registrosPorPagina = 10; // Número de registros por página
        let paginaActual = 1;
        const filas = document.querySelectorAll("#tablaCuerpo tr");
        const totalPaginas = Math.ceil(filas.length / registrosPorPagina);

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fin = inicio + registrosPorPagina;

            filas.forEach((fila, indice) => {
                fila.style.display = (indice >= inicio && indice < fin) ? "" : "none";
            });

            actualizarPaginacion(pagina);
        }

        function actualizarPaginacion(pagina) {
            const paginacion = document.getElementById("paginacion");
            paginacion.innerHTML = "";

            for (let i = 1; i <= totalPaginas; i++) {
                const li = document.createElement("li");
                li.classList.add("page-item");
                if (i === pagina) {
                    li.classList.add("active");
                }
                const a = document.createElement("a");
                a.classList.add("page-link");
                a.textContent = i;
                a.href = "#";
                a.onclick = function (event) {
                    event.preventDefault();
                    mostrarPagina(i);
                };
                li.appendChild(a);
                paginacion.appendChild(li);
            }
        }

        let debounceTimer;
        function filtrarTabla() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const input = document.getElementById("buscarInput").value.toUpperCase();
                filas.forEach(fila => {
                    const celdas = fila.getElementsByTagName("td");
                    let mostrarFila = false;
                    for (let i = 0; i < celdas.length; i++) {
                        const textoCelda = celdas[i].textContent || celdas[i].innerText;
                        if (textoCelda.toUpperCase().indexOf(input) > -1) {
                            mostrarFila = true;
                            break;
                        }
                    }
                    fila.style.display = mostrarFila ? "" : "none";
                });
            }, 300); // 300ms debounce
        }
        
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar este registro?');
        }

        // Inicializar paginación
        mostrarPagina(paginaActual);
    </script>
    <script>        
        // Datos de género
        var generoData = {
            labels: ['HOMBRES', 'MUJERES', 'NIÑ@S'],
            datasets: [{
                label: 'Distribución por Género',
                data: [
                    <?= $hombres ?>,
                    <?= $mujeres ?>,
                    <?= $ninos ?>
                ],
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12']
            }]
        };
        // Datos de nivel socioeconómico
        var nivelSocioeconomicoData = {
            labels: ['NO POBRE', 'POBRE', 'POBRE EXTREMO'],
            datasets: [{
                label: 'Nivel Socioeconómico (%)',
                data: [
                    <?= round($porcentajeNivelSocioeconomico['NO POBRE'], 2) ?>, 
                    <?= round($porcentajeNivelSocioeconomico['POBRE'], 2) ?>, 
                    <?= round($porcentajeNivelSocioeconomico['POBRE EXTREMO'], 2) ?>
                ],
                backgroundColor: ['#2ecc71', '#f39c12', '#e74c3c']
            }]
        };

        // Datos de tipo de discapacidad
        var tipoDiscapacidadData = {
            labels: ['LEVE', 'MODERADA', 'SEVERA'],
            datasets: [{
                label: 'Tipo de Discapacidad (%)',
                data: [
                    <?= round($porcentajeTipoDiscapacidadCarnet['LEVE'], 2) ?>, 
                    <?= round($porcentajeTipoDiscapacidadCarnet['MODERADA'], 2) ?>, 
                    <?= round($porcentajeTipoDiscapacidadCarnet['SEVERA'], 2) ?>
                ],
                backgroundColor: ['#2ecc71', '#f1c40f', '#e74c3c']
            }]
        };
        
        // Configuración para el gráfico de Distribución por Género
        var ctx3 = document.getElementById('generoChart').getContext('2d');
        var generoChart = new Chart(ctx3, {
            type: 'pie',
            data: generoData
        });

        // Configuración para el gráfico de Nivel Socioeconómico
        var ctx1 = document.getElementById('nivelSocioeconomicoChart').getContext('2d');
        var nivelSocioeconomicoChart = new Chart(ctx1, {
            type: 'pie',
            data: nivelSocioeconomicoData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Muestra el porcentaje en la etiqueta
                            }
                        }
                    }
                }
            }
        });

        // Configuración para el gráfico de Tipo de Discapacidad
        var ctx2 = document.getElementById('discapacidadChart').getContext('2d');
        var discapacidadChart = new Chart(ctx2, {
            type: 'pie',
            data: tipoDiscapacidadData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Muestra el porcentaje en la etiqueta
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
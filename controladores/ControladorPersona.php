<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */
require_once '../modelos/Conexion.php';
require_once '../modelos/Persona.php';

class ControladorPersona {
    private $modelo;

    public function __construct() {
        $this->modelo = new Persona();
    }

    public function listarPersonas() {
        return $this->modelo->obtenerPersonas();
    }
    
    public function listarPersonasPorNivelSocioeconomico($nivel) {
        return $this->modelo->obtenerPersonasPorNivelSocioeconomico($nivel);
    }
    
    public function listarPersonasPorTipoDiscapacidadCarnet($tipocarnet) {
        return $this->modelo->obtenerPersonasPorTipoDiscapacidadCarnet($tipocarnet);
    }

    public function agregarPersona($datosPersona) {
        return $this->modelo->agregar($datosPersona);
    }

    public function editarPersona($id, $datosActualizados) {
        return $this->modelo->actualizar($id, $datosActualizados);
    }

    public function eliminarPersona($id) {
        return $this->modelo->eliminar($id);
    }
    public function obtenerPersonaPorId($id) {
        return $this->modelo->obtenerPersonaPorId($id);
    }
}
?>

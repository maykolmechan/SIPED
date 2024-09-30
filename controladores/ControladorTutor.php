<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */
require_once '../modelos/Conexion.php';
require_once '../modelos/Tutor.php';

class ControladorTutor {
    private $modelo;

    public function __construct() {
        $this->modelo = new Tutor();
    }

    // Método para listar todos los tutores
    public function listarTutores() {
        return $this->modelo->obtenerTutores();
    }

    // Método para listar tutor por ID
    public function obtenerTutorPorId($id) {
        return $this->modelo->obtenerTutorPorId($id);
    }    
    
    // Método para listar tutores por persona con discapacidad
    public function listarTutoresPorPersona($persona_discapacidad_id) {
        return $this->modelo->obtenerTutoresPorPersona($persona_discapacidad_id);
    }

    // Método para agregar un nuevo tutor
    public function agregarTutor($datosTutor) {
        return $this->modelo->agregarTutor($datosTutor);
    }

    // Método para editar un tutor
    public function editarTutor($id, $datosActualizados) {
        return $this->modelo->actualizarTutor($id, $datosActualizados);
    }

    // Método para eliminar un tutor
    public function eliminarTutor($id) {
        return $this->modelo->eliminarTutor($id);
    }
}
?>

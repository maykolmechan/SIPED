<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */

require_once 'Conexion.php';

class Tutor {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
    }

    // Obtener todos los tutores
    public function obtenerTutores() {
        $query = $this->db->prepare("SELECT * FROM tutores");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener tutores por ID 
    public function obtenerTutorPorId($id) {
        $query = $this->db->prepare("SELECT * FROM tutores WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener tutores por ID de la persona con discapacidad
    public function obtenerTutoresPorPersona($persona_discapacidad_id) {
        $query = $this->db->prepare("SELECT * FROM tutores WHERE persona_discapacidad_id = :persona_discapacidad_id");
        $query->execute(['persona_discapacidad_id' => $persona_discapacidad_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo tutor
    public function agregarTutor($datos) {
        $query = $this->db->prepare("INSERT INTO tutores 
            (persona_discapacidad_id, nombre, dni, sexo, celular, parentezco, direccion_actual) 
            VALUES (:persona_discapacidad_id, :nombre, :dni, :sexo, :celular, :parentezco, :direccion_actual)");
        return $query->execute($datos);
    }

    // Actualizar un tutor existente
    public function actualizarTutor($id, $datosActualizados) {
        $datosActualizados['id'] = $id; // Asegúrate de que el ID esté en los datos actualizados
        $query = $this->db->prepare("UPDATE tutores 
            SET nombre = :nombre, dni = :dni, sexo = :sexo, celular = :celular, parentezco = :parentezco, direccion_actual = :direccion_actual 
            WHERE id = :id");
        return $query->execute($datosActualizados);
    }


    // Eliminar un tutor
    public function eliminarTutor($id) {
        $query = $this->db->prepare("DELETE FROM tutores WHERE id = :id");
        return $query->execute(['id' => $id]);
    }
}
?>

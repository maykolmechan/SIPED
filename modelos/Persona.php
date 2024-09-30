<?php
/**
 *
 * @author Maykol Caicedo Mechan
 */

require_once 'Conexion.php';

class Persona {
    private $db;
    //QUIAMOS VARIABLES INNECESARIAS

    public function __construct() {
        $this->db = (new Conexion())->conectar();
    }

    public function obtenerPersonas() {
        $query = $this->db->prepare("SELECT * FROM personas_con_discapacidad");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPersonasPorNivelSocioeconomico($nivel) {
        $query = $this->db->prepare("SELECT * FROM personas_con_discapacidad WHERE nivel_socioeconomico = :nivel");
        $query->execute(['nivel' => $nivel]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPersonasPorTipoDiscapacidadCarnet($tipoCarnet) {
        $query = $this->db->prepare("SELECT * FROM personas_con_discapacidad WHERE tipo_discapacidad_carnet = :tipo_discapacidad_carnet");
        $query->execute(['tipo_discapacidad_carnet' => $tipoCarnet]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerPersonaPorId($id) {
        $query = $this->db->prepare("SELECT * FROM personas_con_discapacidad WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($datos) {
        $query = $this->db->prepare("INSERT INTO personas_con_discapacidad 
            (nombre_apellido, dni, sexo, fecha_nacimiento, seguro, estado_civil, celular, direccion, tipo_discapacidad, grado_instruccion, nivel_socioeconomico, actualmente_trabaja, lugar_trabajo, tiene_carnet_discapacidad, numero_carnet, tipo_discapacidad_carnet)
            VALUES (:nombre_apellido, :dni, :sexo, :fecha_nacimiento,:seguro, :estado_civil, :celular, :direccion, :tipo_discapacidad, :grado_instruccion, :nivel_socioeconomico, :actualmente_trabaja, :lugar_trabajo, :tiene_carnet_discapacidad, :numero_carnet, :tipo_discapacidad_carnet)");
        return $query->execute($datos);
    }

    public function actualizar($id, $datosActualizados) {
        $query = $this->db->prepare("UPDATE personas_con_discapacidad 
            SET nombre_apellido = :nombre_apellido, 
                dni = :dni, 
                sexo = :sexo, 
                fecha_nacimiento = :fecha_nacimiento, 
                seguro = :seguro, 
                estado_civil = :estado_civil, 
                celular = :celular, 
                direccion = :direccion, 
                tipo_discapacidad = :tipo_discapacidad, 
                grado_instruccion = :grado_instruccion, 
                nivel_socioeconomico = :nivel_socioeconomico, 
                actualmente_trabaja = :actualmente_trabaja, 
                lugar_trabajo = :lugar_trabajo, 
                tiene_carnet_discapacidad = :tiene_carnet_discapacidad, 
                numero_carnet = :numero_carnet, 
                tipo_discapacidad_carnet = :tipo_discapacidad_carnet 
            WHERE id = :id");    
        // Asegúrate de incluir el ID en los datos actualizados
        $datosActualizados['id'] = $id;

        return $query->execute($datosActualizados);
    }


    public function eliminar($id) {
        $query = $this->db->prepare("DELETE FROM personas_con_discapacidad WHERE id = :id");
        return $query->execute(['id' => $id]);
    }
}
?>

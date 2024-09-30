<?php
class Conexion {
    private $host = "localhost";
    private $dbname = "bdd_siped";
    private $user = "root";
    private $password = "";

    public function conectar() {
        try {
            $conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>

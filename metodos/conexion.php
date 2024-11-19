<?php
class ConexionBD {
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = "";
    private $baseDatos = 'judav';
    private $conexion;

    public function __construct() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->password, $this->baseDatos);
        if (!$this->conexion) {
            die("Error de conexión: " . mysqli_connect_error());  // Error detallado
        }
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        mysqli_close($this->conexion);
    }
}
?>

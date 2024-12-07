<?php
class ConexionBD {
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = 'root';
    private $baseDatos = 'judav';
    private $conexion;

    // Constructor que establece la conexión
    public function __construct() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->password, $this->baseDatos);
        if (!$this->conexion) {
            die("Error de conexión: " . mysqli_connect_error()); // Mensaje detallado de error
        }
    }

    // Método para obtener la conexión
    public function obtenerConexion() {
        return $this->conexion;
    }

    // Método para cerrar la conexión
    public function cerrarConexion() {
        if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }
}

?>

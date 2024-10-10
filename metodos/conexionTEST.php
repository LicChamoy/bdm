<?php

require_once "../metodos/conexion.php";
try{
    $query = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexion, $query);

}catch(exception $e){
    echo 'pq:', $e ->getMessage(), "\n";
}
    
if ($resultado) {
    echo "La conexión a la base de datos y la consulta fueron exitosas.";
} else {
    echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
}
mysqli_close($conexion);
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Bloqueados</title>
    <link rel="stylesheet" href="usubloqu.css">
</head>
<body>
    <header>
        <h1>Usuarios Bloqueados</h1>
    </header>

    <main>
        <div class="blocked-users-container">
            <div class="header-container">
                <a href="vistaAdmin.html" class="back-button">Volver al Panel de Administración</a>
            </div>
            <table class="blocked-users-table">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../metodos/conexion.php';
                    $conexionBD = new ConexionBD();
                    $conexion = $conexionBD->obtenerConexion();

                    // Consulta para obtener usuarios bloqueados
                    $query = "SELECT nombre, apellidos, email FROM UsuariosBloqueados";
                    $result = $conexion->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $nombreCompleto = $row['nombre'] . ' ' . $row['apellidos'];
                            $email = $row['email'];

                            echo "<tr>
                                    <td>{$nombreCompleto}</td>
                                    <td>{$email}</td>
                                    <td>
                                        <button class='unblock-button' onclick='reactivateUser(\"{$email}\")'>Reactivar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='3'>No hay usuarios bloqueados.</td>
                              </tr>";
                    }

                    $conexionBD->cerrarConexion();
                    ?>
                </tbody>
            </table>
        </div>      
    </main>

    <script>
        // Función para reactivar al usuario usando AJAX
        function reactivateUser(email) {
            fetch('../metodos/ReactivateUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Recarga la página para actualizar la lista
            })
            .catch(error => {
                console.error('Error al reactivar al usuario:', error);
            });
        }
    </script>
</body>
</html>

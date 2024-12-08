<?php
require '../metodos/conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

// Obtener el rol desde la solicitud GET
$role = isset($_GET['role']) ? $_GET['role'] : '';

$stmt = $conexion->prepare("CALL ObtenerUsuarios(?)");
$stmt->bind_param("s", $role);
$stmt->execute();

$result = $stmt->get_result();

$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

$conexionBD->cerrarConexion();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios Registrados</title>
        <link rel="stylesheet" href="reporte.css">
    </head>
    <body>
        <header>
            <h1>Usuarios Registrados</h1>
        </header>

        <main>
            <form id="panelForm">
                <div class="users-container">
                    <div class="header-container">
                        <a href="vistaAdmin.html" class="back-button">Volver al Panel de Administración</a>
                    </div>
                    <div class="filter-container">
                        <label for="role-filter">Filtrar por rol:</label>
                        <select id="role-filter" onchange="filterByRole()">
                            <option value="">Todos</option>
                            <option value="alumno">Alumno</option>
                            <option value="docente">Instructor</option>
                        </select>
                    </div>
                    <table class="users-table">
                        <thead>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Registro</th>
                            <th>Cursos Inscritos</th>
                            <th>Cursos Terminados</th>
                            <th>Cursos Ofrecidos</th>
                            <th>Total de Ganancias</th>
                        </thead>
                        <tbody id="users-tbody">
                            <?php foreach ($usuarios as $user): ?>
                                <tr class="user-row" data-role="<?= $user['rol'] ?>">
                                    <td><?= $user['rol'] ?></td>
                                    <td><?= $user['nombre'] . ' ' . $user['apellidos'] ?></td>
                                    <td><?= $user['fechaDeRegistro'] ?></td>
                                    <td><?= $user['cursosInscritos'] ?? '-' ?></td>
                                    <td><?= $user['cursosTerminados'] ?? '-' ?></td>
                                    <td><?= $user['cursosOfrecidos'] ?? '-' ?></td>
                                    <td><?= $user['ganancias'] ?? '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </main>

        <script>
            // Función para filtrar los usuarios según el rol
            function filterByRole() {
                const role = document.getElementById('role-filter').value;
                const rows = document.querySelectorAll('.user-row');

                rows.forEach(row => {
                    const userRole = row.getAttribute('data-role');
                    if (role === '' || userRole === role) {
                        row.style.display = '';  // Mostrar la fila si coincide con el rol
                    } else {
                        row.style.display = 'none';  // Ocultar la fila si no coincide con el rol
                    }
                });
            }
            window.onload = () => filterByRole();
        </script>
    </body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrar Categorías</title>
        <link rel="stylesheet" href="regicat.css">
    </head>
    <body>
        <header>
            <h1>Registrar Categorías</h1>
        </header>

        <main>
            <form id="panelForm">
                <div class="form-container">
                    <div class="header-container">
                        <a href="vistaAdmin.html" class="back-button">Volver al Panel de Administración</a>
                    </div>
                    <form id="category-form">
                        <div class="form-section">
                            <label for="category-name">Nombre de la Categoría:</label>
                            <input type="text" id="category-name" name="category-name" placeholder="Ingresa el nombre de la categoría" required>

                            <label for="category-description">Descripción de la Categoría:</label>
                            <input type="text" id="category-description" name="category-description" placeholder="Ingresa la descripción de la categoría" required>

                            <button  type="button" 
                                onclick="regCat(
                                    document.getElementById('category-name').value,
                                    document.getElementById('category-description').value,
                                    '<?php echo $_SESSION['user_id']; ?>'
                                )">
                                Agregar Categoría
                            </button>
                        </div>
                    </form>
        
                    <div class="categories-list-container">
                        <h2>Categorías y Número de Cursos</h2>
                        <table class="categories-table">
                            <thead>
                                <tr>
                                    <th>Nombre de la Categoría</th>
                                    <th>Descripción</th>
                                    <th>Creador</th>
                                    <th>Total de Cursos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require '../metodos/conexion.php';
                                $conexionBD = new ConexionBD();
                                $conexion = $conexionBD->obtenerConexion();

                                // Consulta a la vista
                                $query = "SELECT nombre_categoria, descripcion_categoria, nombre_creador, total_cursos FROM vista_categorias_cursos";
                                $result = $conexion->query($query);

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['nombre_categoria']}</td>
                                                <td>{$row['descripcion_categoria']}</td>
                                                <td>{$row['nombre_creador']}</td>
                                                <td>{$row['total_cursos']}</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr>
                                            <td colspan='4'>No hay categorías registradas.</td>
                                        </tr>";
                                }

                                $conexionBD->cerrarConexion();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>   
            </form>
        </main>

        <script>
            function regCat(nombre, descripcion, idCreador) {
                alert("Registrando categoria con los siguientes valores:\n" +
                "Nombre: " + nombre + "\n" +
                "Descripción: " + descripcion + "\n";
                fetch('../metodos/registrarCategoria.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'category-name': nombre,
                        'category-description': descripcion,
                        'user_id': idCreador
                    })
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error al registrar la categoría:', error);
                });
            }
        </script>
    </body>
</html>

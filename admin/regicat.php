<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrar Categorías</title>
        <link rel="stylesheet" href="regicat.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

                            <button type="button" id="add-category">Agregar Categoría</button>
                        </div>
                    </form>
        
                    <div class="categories-list">
                        <h2>Categorías Registradas:</h2>
                        <ul id="categories-list"></ul>
                    </div>
                </div>   
            </form>
        </main>

        <script>
            $('#add-category').on('click', function() {
                var nombreCategoria = $('#category-name').val();
                var descripcionCategoria = $('#category-description').val();
                var idCreador = '<?php echo $_SESSION['user_id']; ?>'; // Aquí puedes usar el ID del usuario autenticado (puedes obtenerlo de la sesión también)
                
                $.ajax({
                    url: 'registrar_categoria.php',
                    type: 'POST',
                    data: {
                        'category-name': nombreCategoria,
                        'category-description': descripcionCategoria,
                        'id-creator': idCreador
                    },
                    success: function(response) {
                        alert(response);
                        $('#category-name').val('');
                        $('#category-description').val('');
                        loadCategories();
                    },
                    error: function(xhr, status, error) {
                        alert('Error al registrar la categoría: ' + error);
                    }
                });
            });
        </script>
    </body>
</html>

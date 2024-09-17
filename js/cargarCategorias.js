document.addEventListener('DOMContentLoaded', function() {
    // Esta función debe ser adaptada para cargar categorías desde una fuente real, como una base de datos.
    const categories = [
        'Programación',
        'Diseño',
        'Marketing',
        'Negocios',
        'Fotografía'
    ];

    const categorySelect = document.getElementById('course-category');

    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });
});

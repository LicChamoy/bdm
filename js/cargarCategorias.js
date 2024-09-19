document.addEventListener('DOMContentLoaded', function() {
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

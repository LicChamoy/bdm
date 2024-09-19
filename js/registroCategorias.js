document.addEventListener('DOMContentLoaded', function() {
    const addCategoryButton = document.getElementById('add-category');
    const categoriesList = document.getElementById('categories-list');

    addCategoryButton.addEventListener('click', function() {
        const categoryNameInput = document.getElementById('category-name');
        const categoryName = categoryNameInput.value.trim();

        if (categoryName) {
            const listItem = document.createElement('li');
            listItem.textContent = categoryName;
            categoriesList.appendChild(listItem);
            categoryNameInput.value = ''; // Clear the input field
        } else {
            alert('Por favor, ingresa un nombre para la categoría.');
        }
    });
});

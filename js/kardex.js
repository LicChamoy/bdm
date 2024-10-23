document.addEventListener("DOMContentLoaded", () => {
    // Simular la carga de categorías
    const categorySelect = document.getElementById("category");
    const categories = ["Diseño Gráfico", "Marketing Digital", "Fotografía y Video", "Escritura Creativa"];
    categories.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.toLowerCase();
        option.textContent = cat;
        categorySelect.appendChild(option);
    });

    // Manejar el formulario de filtros
    document.getElementById("filterForm").addEventListener("submit", (event) => {
        event.preventDefault();
        // Obtener los valores de los filtros y aplicarlos
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;
        const category = document.getElementById("category").value;
        const status = document.getElementById("status").value;
        const active = document.getElementById("active").value;

        // Implementar lógica para filtrar los cursos del Kardex
        console.log("Aplicando filtros:", { startDate, endDate, category, status, active });
    });
});

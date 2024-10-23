function applyFilters() {
    // Obtener los valores de los filtros
    const dateRange = document.getElementById('dateRange').value;
    const category = document.getElementById('categoryFilter').value;
    const activeOnly = document.getElementById('activeCourses').checked;

    // Simular la consulta de datos
    const courses = [
        { image: "imagenes/c1.png", title: "Curso de Fotografía", students: 30, averageLevel: 82, income: 1500 },
        { image: "imagenes/c3.png", title: "Curso de Marketing Digital", students: 20, averageLevel: 99, income: 2000 },
    ];

    const courseList = document.getElementById('courseList');
    courseList.innerHTML = ''; // Limpiar la tabla antes de llenarla

    let totalIncome = 0;

    courses.forEach(course => {
        const row = document.createElement('tr');

        // Crear celdas para la tabla
        row.innerHTML = `
            <td><img src="${course.image}" alt="${course.title}" style="width:50px; height:auto;"></td>
            <td>${course.title}</td>
            <td>${course.students}</td>
            <td>${createPercentageBar(course.averageLevel)}</td>
            <td>$${course.income.toLocaleString('es-ES', { minimumFractionDigits: 2 })}</td>
        `;
        courseList.appendChild(row);
        totalIncome += course.income;
    });

    document.getElementById('totalIncome').innerHTML = `Total: $${totalIncome.toLocaleString('es-ES', { minimumFractionDigits: 2 })}`;
}

// Función para crear la barra de porcentaje
function createPercentageBar(percentage) {
    const container = document.createElement('div');
    container.style.width = '100%';
    container.style.backgroundColor = '#e0e0e0';
    container.style.borderRadius = '5px';
    container.style.overflow = 'hidden';

    const bar = document.createElement('div');
    bar.style.width = percentage + '%';
    bar.style.height = '10px';
    bar.style.backgroundColor = '#4caf50'; // Color de la barra
    container.appendChild(bar);

    return container.outerHTML; // Retornar como HTML para usar en la tabla
}

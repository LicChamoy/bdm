function applyFilters() {
    const dateRange = document.getElementById('dateRange').value;
    const category = document.getElementById('categoryFilter').value;
    const activeOnly = document.getElementById('activeCourses').checked;

    // Simulación de datos de alumnos por curso
    const courses = [
        {
            title: "Curso 1",
            students: [
                { name: "Alumno 1", registrationDate: "01 Feb 2024", progress: "80%", pricePaid: 150, paymentMethod: "Tarjeta" },
                { name: "Alumno 2", registrationDate: "15 Mar 2024", progress: "100%", pricePaid: 150, paymentMethod: "PayPal" },
            ],
            income: 300
        },
        {
            title: "Curso 2",
            students: [
                { name: "Alumno 3", registrationDate: "20 Ene 2024", progress: "60%", pricePaid: 200, paymentMethod: "Transferencia" },
            ],
            income: 200
        },
    ];

    const studentList = document.getElementById('studentList');
    studentList.innerHTML = ''; // Limpiar la tabla antes de llenarla

    let totalIncome = 0;

    courses.forEach(course => {
        course.students.forEach(student => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.name}</td>
                <td>${student.registrationDate}</td>
                <td>${student.progress}</td>
                <td>$${student.pricePaid.toLocaleString('es-ES', { minimumFractionDigits: 2 })}</td>
                <td>${student.paymentMethod}</td>
            `;
            studentList.appendChild(row);
            totalIncome += student.pricePaid;
        });
    });

    document.getElementById('totalIncome').innerHTML = `Total: $${totalIncome.toLocaleString('es-ES', { minimumFractionDigits: 2 })}`;
}

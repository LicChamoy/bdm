const users = [
    {role: 'alumno', username: 'Juanito', name: 'Juan Pérez', registrationDate: '2023-01-15', coursesEnrolled: 5, coursesCompleted: 3},
    {role: 'instructor', username: 'ProfAna', name: 'Ana Gómez', registrationDate: '2022-07-22', coursesOffered: 8, totalEarnings: 1200},
];

function loadTableData(role) {
    const tableBody = document.getElementById('users-tbody');
    const headerRow = document.getElementById('header-row');
    
    tableBody.innerHTML = '';
    headerRow.innerHTML = '';

    if (role === 'alumno') {
        headerRow.innerHTML = `
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Fecha de Registro</th>
            <th>Cursos Inscritos</th>
            <th>Cursos Terminados</th>
        `;
        
        users.filter(user => user.role === 'alumno').forEach(user => {
            tableBody.innerHTML += `
                <tr>
                    <td>${user.username}</td>
                    <td>${user.name}</td>
                    <td>${user.registrationDate}</td>
                    <td>${user.coursesEnrolled}</td>
                    <td>${user.coursesCompleted}</td>
                </tr>
            `;
        });
    } else if (role === 'instructor') {
        headerRow.innerHTML = `
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Fecha de Registro</th>
            <th>Cursos Ofrecidos</th>
            <th>Total de Ganancias</th>
        `;
        
        users.filter(user => user.role === 'instructor').forEach(user => {
            tableBody.innerHTML += `
                <tr>
                    <td>${user.username}</td>
                    <td>${user.name}</td>
                    <td>${user.registrationDate}</td>
                    <td>${user.coursesOffered}</td>
                    <td>${user.totalEarnings}</td>
                </tr>
            `;
        });
    } else {
        headerRow.innerHTML = `
            <th>Rol</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Fecha de Registro</th>
            <th>Cursos Inscritos</th>
            <th>Cursos Terminados</th>
            <th>Cursos Ofrecidos</th>
            <th>Total de Ganancias</th>
        `;
        
        users.forEach(user => {
            tableBody.innerHTML += `
                <tr>
                    <td>${user.role}</td>
                    <td>${user.username}</td>
                    <td>${user.name}</td>
                    <td>${user.registrationDate}</td>
                    <td>${user.coursesEnrolled || '-'}</td>
                    <td>${user.coursesCompleted || '-'}</td>
                    <td>${user.coursesOffered || '-'}</td>
                    <td>${user.totalEarnings || '-'}</td>
                </tr>
            `;
        });
    }
}

function filterByRole() {
    const role = document.getElementById('role-filter').value;
    loadTableData(role);
}

window.onload = () => loadTableData('');
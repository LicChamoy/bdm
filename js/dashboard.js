// Inicializa el estado de registro
let isRegistered = false; // Cambia esto según el estado real del usuario
window.selectedCourse = ""; // Inicializa esta variable
let selectedCoursePrice = ""; // Para almacenar el precio del curso

// Función para mostrar el modal con el mensaje de inscripción
function showDetails(courseTitle, coursePrice) {
    window.selectedCourse = courseTitle; // Asigna el título del curso
    selectedCoursePrice = coursePrice; // Asigna el precio del curso
    const modal = document.getElementById("modal");
    const modalText = document.getElementById("modalText");
    modalText.textContent = `¿Deseas inscribirte en el curso "${courseTitle}"?`;
    modal.style.display = "block";
}

// Cierra el modal
function closeModal() {
    document.getElementById("modal").style.display = "none";
}

// Redirige a la página de inscripción
function confirmEnrollment() {
    closeModal();
    console.log("Usuario registrado:", isRegistered);
    console.log("Curso seleccionado:", window.selectedCourse);
    console.log("Precio del curso:", selectedCoursePrice);

    // Verifica si el usuario está inscrito
    if (isRegistered) {
        // Redirige a la página de confirmación
        window.location.href = 'course-details.html'; // Asegúrate de que el nombre del archivo coincida
    } else {
        // Si el curso es gratis
        if (selectedCoursePrice === "Gratis") {
            alert("Su inscripción ha sido exitosa, ¡bienvenido!");
            window.location.href = 'course-details.html'; // Redirige a confirmación
        } else {
            // Redirige a la página de pago y pasa el nombre del curso
            const courseName = window.selectedCourse; // Asegúrate de que esta variable tenga el valor correcto
            if (courseName) {
                window.location.href = `course-payment.html?course=${encodeURIComponent(courseName)}`;
            } else {
                alert("Error: No se pudo obtener el nombre del curso.");
            }
        }
    }
}

function viewProfile() {
    window.location.href = 'perfil.html'; // Redirige a la página del perfil
}

function viewChat() {
    window.location.href = 'chat.html'; // Redirige a la página del perfil
}

function viewKardex() {
    window.location.href = 'kardex.html'; // Redirige a la página del perfil
}
// Función de búsqueda parcial por título del curso
function searchCourses() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const courses = document.querySelectorAll('.course');
    
    courses.forEach(course => {
        const title = course.getAttribute('data-title').toLowerCase();
        if (title.includes(input)) {
            course.style.display = "block";
        } else {
            course.style.display = "none";
        }
    });
}

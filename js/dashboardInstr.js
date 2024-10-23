function viewProfile() {
    window.location.href = 'perfil.html'; // Redirige a la página del perfil
}

function viewChat() {
    window.location.href = 'chat.html'; // Redirige a la página del perfil
}

function newCourse() {
    window.location.href = 'registercourse.html'; // Redirige a la página del perfil
}
// Función para ver detalles del curso
function verDetalles(curso) {
    // Redirigir a la página de detalles del curso con opciones para dar de baja o elegir forma de pago
    window.location.href = 'detailscourse.html?curso=' + encodeURIComponent(curso);
}
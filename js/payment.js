// Obtener los parámetros de la URL
const urlParams = new URLSearchParams(window.location.search);
const courseName = urlParams.get('course');
const option = urlParams.get('option');

// Mostrar el nombre del curso
document.getElementById('selectedCourse').textContent = decodeURIComponent(courseName);

// Mostrar si es curso completo o nivel
let optionText = '';
if (option === 'complete') {
    optionText = 'Curso Completo';
} else if (option.startsWith('level')) {
    optionText = `Nivel ${option.charAt(option.length - 1)}`; // Asume que 'level1', 'level2', etc. están en el formato adecuado
}

const courseOptionElement = document.createElement('p');
courseOptionElement.textContent = `Opción seleccionada: ${optionText}`;
document.querySelector('main').appendChild(courseOptionElement);

// Manejo del formulario de pago
document.getElementById('paymentForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert("Su pago ha sido procesado con éxito. ¡Gracias!");
    window.location.href = 'course-details.html'; // Redirigir a la página de confirmación
});

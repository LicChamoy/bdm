// Obtener el parámetro del curso de la URL
const urlParams = new URLSearchParams(window.location.search);
const curso = urlParams.get('curso');

// Mostrar el título del curso en la página
document.getElementById('courseTitle').innerText = 'Detalles del curso: ' + curso;

// Función para dar de baja el curso
function darDeBajaCurso() {
    const confirmar = confirm(`¿Estás seguro de que deseas dar de baja el curso ${curso}?`);
    if (confirmar) {
        alert(`El curso ${curso} ha sido dado de baja.`);
        // Aquí puedes añadir lógica adicional si es necesario
    }
}

// Función para seleccionar forma de pago
function seleccionarFormaDePago() {
    alert(`Selecciona una forma de pago para el curso ${curso}.`);
    // Redirigir a una página o abrir un modal con las opciones de pago
}

function guardarCambios() {
    const title = document.getElementById('courseTitle').innerText;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const images = document.getElementById('imageUpload').files;
    const video = document.getElementById('videoUpload').files[0];
    const docu = document.getElementById('docuUpload').files;

    // Aquí puedes agregar la lógica para guardar los cambios
    // Ejemplo: subir archivos a un servidor, guardar en localStorage, etc.

    console.log("Título:", title);
    console.log("Descripción:", description);
    console.log("Precio:", price);
    console.log("Imágenes:", images);
    console.log("Video:", video);
    console.log("Documento:", docu);

    // Muestra un mensaje de confirmación (puedes personalizarlo)
    alert("Cambios guardados con éxito");
}

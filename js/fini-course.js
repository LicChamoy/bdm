document.getElementById('feedback-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const comment = document.getElementById('comment').value;
    const rating = document.getElementById('rating').value;
    alert(`Comentario: ${comment}\nCalificación: ${rating}`);
    // Aquí podrías agregar lógica para enviar el comentario a un servidor
    document.getElementById('feedback-form').reset(); // Resetea el formulario
});
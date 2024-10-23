function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const messageText = messageInput.value.trim();
    const messageContainer = document.getElementById('messageContainer');

    if (messageText !== "") {
        const currentTime = new Date();
        const hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedTime = `${hours % 12 || 12}:${minutes < 10 ? '0' + minutes : minutes} ${ampm}`;

        // Crear nuevo mensaje con la hora
        const newMessage = document.createElement('div');
        newMessage.classList.add('message');
        newMessage.innerHTML = `<strong>Alex:</strong> ${messageText} <span class="timestamp">[${formattedTime}]</span>`;

        // Agregar el mensaje al contenedor
        messageContainer.appendChild(newMessage);
        messageInput.value = ""; // Limpia el campo de entrada
        messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll 
    }
}
function logout() {
    // Redirige a la página de inicio
    window.location.href = 'dashboard.html'; 
}

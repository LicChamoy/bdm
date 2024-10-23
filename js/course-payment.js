// Variables para el modal y botones
const modal = document.getElementById('modal');
const modalText = document.getElementById('modal-text');
const closeModal = document.querySelector('.close');
const confirmPurchase = document.getElementById('confirm-purchase');

// Comprar niveles individuales
const buyLevelButtons = document.querySelectorAll('.buy-level');
let selectedPurchase = '';
let purchaseOption = '';

buyLevelButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault(); // Prevenir la acción predeterminada del botón
        const level = button.getAttribute('data-level');
        const price = button.getAttribute('data-price');
        selectedPurchase = `Nivel ${level} por $${price}`;
        purchaseOption = `level${level}`;
        openModal(selectedPurchase);
    });
});

// Comprar curso completo
const buyFullCourseButton = document.getElementById('buy-full-course');
buyFullCourseButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevenir la acción predeterminada del botón
    selectedPurchase = 'Curso completo por $100';
    purchaseOption = 'complete';
    openModal(selectedPurchase);
});

// Función para abrir el modal
function openModal(purchaseInfo) {
    modal.style.display = 'block';
    modalText.textContent = `Estás a punto de comprar: ${purchaseInfo}. ¿Deseas continuar?`;
}

// Cerrar modal
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Confirmar la compra y redirigir a la página de pago
confirmPurchase.addEventListener('click', () => {
    const courseName = 'Curso de Desarrollo Web'; // Nombre del curso
    // Redirige a payment.html con los parámetros adecuados
    window.location.href = `payment.html?course=${encodeURIComponent(courseName)}&option=${purchaseOption}`;
});

// Cerrar el modal si se hace clic fuera del contenido
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

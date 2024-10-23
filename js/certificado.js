const urlParams = new URLSearchParams(window.location.search);
const courseName = urlParams.get('curso');

document.getElementById('course-name').textContent = courseName;

const today = new Date();
const dateFormatted = today.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });
document.getElementById('issue-date').textContent = dateFormatted;

function downloadCertificate() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const certificateContent = document.getElementById('certificate-preview').innerHTML;

    doc.html(document.getElementById('certificate-preview'), {
        callback: function (doc) {
            doc.save('certificado.pdf');
        },
        x: 10,
        y: 10
    });
}
<?php
require_once 'metodos/conexion.php';

// Obtener la conexión
$conexionBD = new ConexionBD();
$mysqli = $conexionBD->obtenerConexion();

if (isset($_GET['curso_id'])) {
    $cursoId = $_GET['curso_id'];

    // Consulta para obtener los detalles del curso y el certificado
    $query = "SELECT * FROM vista_cursos_usuario WHERE idCurso = ? AND idUsuario = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ii', $cursoId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Curso no encontrado.");
    }
} else {
    die("ID de curso no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vista Previa del Certificado</title>
        <link rel="stylesheet" href="/css/certificado.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    </head>
    <body>

        <div class="certificate-container">
            <h1>Vista Previa del Certificado</h1>
            <div class="certificate-preview" id="certificate-preview">
                <p id="academy-name"><strong>Judav Academy</strong></p> 
                <h2>Certificado de Finalización</h2>
                <p>Otorgado a: <strong><?php echo $_SESSION['user_nombre']; ?></strong></p>
                <p>Por completar satisfactoriamente el curso:</p>
                <p id="course-name"><?php echo $row['cursoTitulo']; ?></p>
                <p>Otorgado por: <strong id="issuer">Impartido por <?php echo $row['instructorNombre'] . ' ' . $row['instructorApellidos']; ?></strong></p>
                <p>Fecha de emisión: <span id="issue-date"><?php echo date('d/m/Y'); ?></span></p>
            </div>

            <button class="download-button" onclick="downloadCertificate()">Descargar Certificado (PDF)</button>
            <button class="finish-button" onclick="window.location.href='kardex.php';">Volver al Kardex</button>
        </div>

        <script>
            function downloadCertificate() {
                const doc = new jsPDF();
                doc.text('Judav Academy - Certificado de Finalización', 20, 20);
                doc.text('Curso: <?php echo $row['cursoTitulo']; ?>', 20, 30);
                doc.text('Instructor: <?php echo $row['instructorNombre'] . ' ' . $row['instructorApellidos']; ?>', 20, 40);
                doc.text('Fecha: <?php echo date('d/m/Y'); ?>', 20, 50);
                doc.save('certificado.pdf');
            }
        </script>
    </body>
</html>

<?php
$stmt->close();
$conexionBD->cerrarConexion(); // Cierra la conexión
?>

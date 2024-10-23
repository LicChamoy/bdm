function showNextContent(id) {
    const nextContent = document.getElementById(id);
    nextContent.classList.toggle('hidden'); 
}


document.getElementById('finish-course').addEventListener('click', function() {
    window.location.href = 'fini-course.html'; 
});

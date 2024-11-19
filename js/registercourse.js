document.addEventListener("DOMContentLoaded", () => {
    const courseForm = document.getElementById("courseForm");
    const addLevelButton = document.getElementById("add-level");
    const levelsList = document.getElementById("levels-list");

    // Agregar un campo de nivel
    addLevelButton.addEventListener("click", () => {
        const newLevelItem = document.createElement("div");
        newLevelItem.classList.add("level-item");
        newLevelItem.innerHTML = '<input type="text" name="level-titles[]" placeholder="Título del nivel" required>';
        levelsList.appendChild(newLevelItem);
    });

    // Enviar el formulario
    courseForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(courseForm);

        try {
            const response = await fetch("/metodos/registercourse.php", {
                method: "POST",
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message);
                courseForm.reset();
                levelsList.innerHTML = "";  // Limpiar niveles
            } else {
                throw new Error(result.message || "Error al registrar el curso");
            }
        } catch (error) {
            alert(`Error: ${error.message}`);
        }
    });
});

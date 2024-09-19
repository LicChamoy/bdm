document.addEventListener('DOMContentLoaded', function() {
    const addLevelButton = document.getElementById('add-level');
    const levelsList = document.getElementById('levels-list');
    let levelCount = 0;

    addLevelButton.addEventListener('click', function() {
        levelCount++;
        const levelDiv = document.createElement('div');
        levelDiv.className = 'level-container';
        levelDiv.id = `level-${levelCount}`;

        levelDiv.innerHTML = `
            <h3>Nivel ${levelCount}</h3>
            <label for="level-title-${levelCount}">Título del Nivel:</label>
            <input type="text" id="level-title-${levelCount}" name="level-title-${levelCount}" placeholder="Ingresa el título del nivel" required>
            
            <label for="sections-${levelCount}">Secciones:</label>
            <button type="button" class="add-section" data-level="${levelCount}">Agregar Sección</button>
            <div id="sections-${levelCount}"></div>
            <span class="remove-level" onclick="removeLevel(${levelCount})">Eliminar Nivel</span>
        `;

        levelsList.appendChild(levelDiv);

        // Agregar eventos a los botones de sección
        document.querySelectorAll('.add-section').forEach(button => {
            button.addEventListener('click', function() {
                const levelId = this.dataset.level;
                addSection(levelId);
            });
        });
    });
});

function addSection(levelId) {
    const sectionsContainer = document.getElementById(`sections-${levelId}`);
    const sectionCount = sectionsContainer.children.length + 1;

    const sectionDiv = document.createElement('div');
    sectionDiv.className = 'section-container';
    sectionDiv.innerHTML = `
        <h4>Sección ${sectionCount}</h4>
        <label for="section-title-${levelId}-${sectionCount}">Título de la Sección:</label>
        <input type="text" id="section-title-${levelId}-${sectionCount}" name="section-title-${levelId}-${sectionCount}" placeholder="Ingresa el título de la sección" required>
        
        <label for="video-url-${levelId}-${sectionCount}">URL del Video:</label>
        <input type="url" id="video-url-${levelId}-${sectionCount}" name="video-url-${levelId}-${sectionCount}" placeholder="Ingresa la URL del video" required>
    `;

    sectionsContainer.appendChild(sectionDiv);
}

function removeLevel(levelId) {
    const levelDiv = document.getElementById(`level-${levelId}`);
    levelDiv.remove();
}

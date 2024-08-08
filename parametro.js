// Obtén la URL actual
const urlActual = window.location.href;

// Verifica si el parámetro 'nombre' ya está presente en la URL
const parametros = new URLSearchParams(window.location.search);
let carpetaNombre = parametros.get("nombre");

if (!carpetaNombre) {
    // Si 'nombre' no está presente, genera una cadena aleatoria
    carpetaNombre = generarCadenaAleatoria();
    // Redirige a la nueva URL con el parámetro 'nombre'
    const urlConParametro = urlActual.includes("?") ? `${urlActual}&nombre=${carpetaNombre}` : `${urlActual}?nombre=${carpetaNombre}`;
    window.location.href = urlConParametro;
} else {
    // Llama a la función para crear la carpeta con el nombre obtenido
    crearCarpeta(carpetaNombre);
}

// Función para generar una cadena aleatoria
function generarCadenaAleatoria() {
    const caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let cadenaAleatoria = '';
    for (let i = 0; i < 3; i++) {
        const caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        cadenaAleatoria += caracterAleatorio;
    }
    return cadenaAleatoria;
}

// Función para crear la carpeta
function crearCarpeta(carpetaNombre) {
    $.ajax({
        url: 'crearCarpeta.php',
        type: 'POST',
        data: { nombreCarpeta: carpetaNombre },
        success: function(response) {
            console.log('Carpeta creada con éxito:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al crear la carpeta:', error);
        }
    });
}

// Función para manejar el evento de envío del formulario
const Form = document.getElementById('form');
Form.addEventListener('submit', (e) => {
    e.preventDefault();
    const fileInput = Form.querySelector('#archivo');
    const file = fileInput.files[0];
    if (file) {
        // Puedes enviar el archivo al servidor para su procesamiento aquí
        console.log('Subir archivo:', file.name);
    } else {
        alert('Por favor, seleccione un archivo primero.');
    }
});

// Función para manejar la zona de arrastre y caída de archivos
const dropArea = document.getElementById('drop-area');
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('drag-over');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('drag-over');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    handleFile(file);
});

// Función para manejar el archivo seleccionado
function handleFile(file) {
    if (file) {
        console.log('Archivo seleccionado:', file.name);
    }
}

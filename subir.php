<?php
// Nombre de la carpeta a crear (obtenido del parámetro)
$carpetaNombre = $_GET['nombre'];

// Ruta donde deseas crear la carpeta (por ejemplo, en la carpeta 'descarga')
$carpetaRuta = "./descarga/" . $carpetaNombre;

// Verifica si la carpeta ya existe antes de crearla
if (!file_exists($carpetaRuta)) {
    // Crea la carpeta con permisos adecuados (por ejemplo, 0755)
    mkdir($carpetaRuta, 0755, true);
    $mensaje = "Carpeta '$carpetaNombre' creada con éxito.";
} else {
    $mensaje = "La carpeta '$carpetaNombre' ya existe.";
}

// Luego, cuando se procese un archivo, guárdalo en la carpeta creada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $archivo = $_FILES['archivo'];

    // Reemplazar espacios con guiones bajos en el nombre del archivo
    $nombreArchivo = str_replace(' ', '_', $archivo['name']);
    $rutaArchivo = $carpetaRuta . '/' . $nombreArchivo;

    if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
        echo "Archivo subido con éxito.";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>

<?php
$carpetaNombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$carpetaRuta = "./descarga/" . $carpetaNombre;

try {
    if (!file_exists($carpetaRuta)) {
        mkdir($carpetaRuta, 0755, true);
        $mensaje = "Carpeta '$carpetaNombre' creada con éxito.";
    } else {
        $mensaje = "La carpeta '$carpetaNombre' ya existe.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['archivo'])) {
            $archivo = $_FILES['archivo'];
            // Reemplazar espacios con guiones bajos en el nombre del archivo
            $nombreArchivo = str_replace(' ', '_', $archivo['name']);
            $rutaArchivo = $carpetaRuta . '/' . $nombreArchivo;

            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                $subido = true;
                $mensaje = "Archivo subido con éxito.";
            } else {
                throw new Exception("Error al subir el archivo.");
            }
        }
    }

    if (isset($_POST['eliminarArchivo'])) {
        $archivoAEliminar = $_POST['eliminarArchivo'];
        $archivoRutaAEliminar = $carpetaRuta . '/' . $archivoAEliminar;
        if (file_exists($archivoRutaAEliminar)) {
            if (unlink($archivoRutaAEliminar)) {
                $mensaje = "Archivo '$archivoAEliminar' eliminado con éxito.";
            } else {
                throw new Exception("Error al eliminar el archivo.");
            }
        } else {
            throw new Exception("El archivo '$archivoAEliminar' no existe.");
        }
    }
} catch (Exception $e) {
    $mensaje = "Error: " . htmlspecialchars($e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compartir Archivos</title>
    <script src="parametros.js"></script>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <header>
        <h1>Compartir Archivos <sup class="beta">BETA</sup></h1>
    </header>
    <main class="content">
        <section class="upload-section">
            <h3>Sube tus archivos y comparte este enlace temporal:</h3>
            <p class="link"><span>ibu.pe/<?php echo htmlspecialchars($carpetaNombre); ?></span></p>
            <div class="drop-area" id="drop-area">
                <form action="" id="form" method="POST" enctype="multipart/form-data">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" class="upload-icon">
                        <path d="M13 19v-4h3l-4-5-4 5h3v4z"></path>
                        <path d="M7 19h2v-2H7c-1.654 0-3-1.346-3-3 0-1.404 1.199-2.756 2.673-3.015l.581-.102.192-.558C8.149 8.274 9.895 7 12 7c2.757 0 5 2.243 5 5v1h1c1.103 0 2 .897 2 2s-.897 2-2 2h-3v2h3c2.206 0 4-1.794 4-4a4.01 4.01 0 0 0-3.056-3.888C18.507 7.67 15.56 5 12 5 9.244 5 6.85 6.611 5.757 9.15 3.609 9.792 2 11.82 2 14c0 2.757 2.243 5 5 5z"></path>
                    </svg>
                    <label for="archivo" class="file-label">
                        Arrastra tus archivos aquí<br>o<br><b>Selecciona un archivo</b>
                    </label>
                    <input type="file" class="file-input" name="archivo" id="archivo" onchange="document.getElementById('form').submit()">
                </form>
            </div>
        </section>

        <section class="file-list-section">
            <h3>Archivos Subidos:</h3>
            <div id="file-list" class="file-list">
                <?php
                $targetDir = $carpetaRuta;
                $files = scandir($targetDir);
                $files = array_diff($files, array('.', '..'));

                if (count($files) > 0) {
                    foreach ($files as $file) {
                        echo "<div class='file-item'>
                            <a href='$carpetaRuta/$file' download class='file-link'>$file</a>
                            <form action='' method='POST' class='delete-form'>
                                <input type='hidden' name='eliminarArchivo' value='$file'>
                                <button type='submit' class='delete-button'>
                                    <svg xmlns='http://www.w3.org/2000/svg' class='icon' width='24' height='24' viewBox='0 0 24 24'>
                                        <path d='M4 7l16 0' />
                                        <path d='M10 11l0 6' />
                                        <path d='M14 11l0 6' />
                                        <path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' />
                                        <path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' />
                                    </svg>
                                </button>
                            </form>
                        </div>";
                    }
                } else {
                    echo "<p>No se han subido archivos.</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>

<?php
if (isset($_POST['nombreCarpeta'])) {
    $carpetaNombre = $_POST['nombreCarpeta'];
    $carpetaRuta = "./descarga/" . $carpetaNombre;

    if (!file_exists($carpetaRuta)) {
        mkdir($carpetaRuta, 0755, true);
        echo "Carpeta '$carpetaNombre' creada con éxito.";
    } else {
        echo "La carpeta '$carpetaNombre' ya existe.";
    }
} else {
    echo "No se ha proporcionado el nombre de la carpeta.";
}
?>

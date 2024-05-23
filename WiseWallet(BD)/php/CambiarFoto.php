<?php
session_start();
include('conexion.php');

if(isset($_POST['cambiar_foto'])) {
    $Correo = $_SESSION['Correo'];

    // Obtener la información del archivo cargado
    $nombre_archivo = $_FILES['Foto_Perfil']['name'];
    $tipo_archivo = $_FILES['Foto_Perfil']['type'];
    $tamaño_archivo = $_FILES['Foto_Perfil']['size'];
    $archivo_temporal = $_FILES['Foto_Perfil']['tmp_name'];

    // Leer el contenido del archivo en forma de cadena de bytes
    $contenido_archivo = file_get_contents($archivo_temporal);

    // Escapar la cadena de bytes para su uso en la consulta SQL
    $contenido_archivo2 = mysqli_real_escape_string($conexion, $contenido_archivo);

    // Consulta para actualizar la foto de perfil del usuario
    $query = "UPDATE usuario SET Imagen = '$contenido_archivo2' WHERE Correo = '$Correo'";
    $resultado = mysqli_query($conexion, $query);

    if($resultado) {
        // Redirigir de vuelta a la página de perfil
        $_SESSION['Imagen'] = $contenido_archivo;
        header("Location: ../Perfil.php");
        exit();
    } else {
        echo "Error al cambiar la foto de perfil";
    }
}
?>
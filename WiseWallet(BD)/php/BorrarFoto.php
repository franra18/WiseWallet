<?php
// Iniciar sesión y conectar a la base de datos
session_start();
include('conexion.php');

// Verificar si se ha enviado la solicitud de eliminación
if(isset($_POST['borrar_foto'])) {
    // Obtener el ID de usuario
    $Correo = $_SESSION['Correo'];

    // Consulta para eliminar la foto de perfil del usuario
    $query = "UPDATE usuario SET Imagen = NULL WHERE Correo = '$Correo'";
    $resultado = mysqli_query($conexion, $query);

    // Verificar si la eliminación fue exitosa
    if($resultado) {
        // Redirigir de vuelta a la página de perfil
        $_SESSION['Imagen'] = null;
        header("Location: ../Perfil.php");
        exit();
    } else {
        echo "Error al eliminar la foto de perfil";
    }
}
?>
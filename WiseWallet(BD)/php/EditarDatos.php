<?php
session_start();
include('conexion.php');

if(isset($_POST['fecha'])) {
    $Correo = $_SESSION['Correo'];

    // Obtener la información de el dato cargado
    $nueva_fecha = $_POST['fecha'];

    $fecha_formateada = date("d-m-Y", strtotime($nueva_fecha));

    // Consulta para actualizar fecha
    $query = "UPDATE usuario SET FechaNac = '$nueva_fecha' WHERE Correo = '$Correo'";
    $resultado = mysqli_query($conexion, $query);

    if($resultado) {
        // Redirigir de vuelta a la página de perfil
        $_SESSION['FechaNac'] = $fecha_formateada;
        header("Location: ../Perfil.php");
        exit();
    } else {
        echo "Error al cambiar el correo";
    }
}
?>
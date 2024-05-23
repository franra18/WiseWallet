<?php
session_start();

if(isset($_POST['Cerrar_Cuenta'])) {

    $_SESSION = array();

    // Finalmente, destruir la sesión
    session_destroy();

    // Redirigir al usuario a la página de inicio
    header("Location: ../iniciarsesion.php");
}
exit();
?>
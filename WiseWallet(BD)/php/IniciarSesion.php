<?php
session_start();

include('conexion.php');

if(isset($_POST['Correo']) && isset($_POST['Contraseña'])){

    function validate($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Correo = validate($_POST['Correo']);
    $Contraseña = validate($_POST['Contraseña']);

    
    $Sql = "SELECT * FROM usuario WHERE Correo = '$Correo' AND Contraseña = '$Contraseña'";
    $result = mysqli_query($conexion, $Sql);

    if(mysqli_num_rows($result) === 1){

        $row = mysqli_fetch_assoc($result);
        if($row['Correo'] === $Correo && $row['Contraseña'] === $Contraseña){

            $_SESSION['Correo'] = $row['Correo'];
            $_SESSION['Contraseña'] = $row['Contraseña'];
            $_SESSION['Nombre'] = $row['Nombre'];
            $_SESSION['Apellidos'] = $row['Apellidos'];
            header("Location: ../Index.html");
            exit();
        }else{

            header("Location: ../iniciarsesion.php?error=El Correo o la Contraseña son incorrectos");
            exit();
        }
        }else{

            header("Location: ../iniciarsesion.php?error=El Correo o la Contraseña son incorrectos");
            exit();
        }
    
}else{

    header("Location: ../iniciarsesion.php?error=El Correo o la Contraseña son incorrectos");
    exit();
}

?>
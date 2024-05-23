<?php

session_start();

include('conexion.php');

if(isset($_POST['Correo']) && isset($_POST['Contraseña']) && isset($_POST['Nombre']) && isset($_POST['Apellidos'])){

    function validar($data){

        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $Correo = validar($_POST['Correo']);
    $Contraseña = validar($_POST['Contraseña']);
    $Nombre = validar($_POST['Nombre']);
    $Apellidos = validar($_POST['Apellidos']);

    $sql = "SELECT * FROM usuario WHERE Correo = '$Correo'";

    $query = $conexion->query($sql);

    if(mysqli_num_rows($query) > 0){

        header("Location: ../registrarse.php?error=La cuenta ya existe");
        exit();
    }else{

        $sql2 = "INSERT INTO usuario(Correo, Contraseña, Nombre, Apellidos) VALUES('$Correo', '$Contraseña', '$Nombre', '$Apellidos')";
        $query2 = $conexion->query($sql2); 

        if($query2){

            header("Location: ../registrarse.php?success=Cuenta creada con exito");
            exit();
        }else{

            header("Location: ../registrarse.php?success=Ha ocurrido un error");
            exit();
        }
    }
}else{

    header("Location: ../registrarse.php");
    exit();
}
?>
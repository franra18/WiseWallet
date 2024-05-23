<?php

session_start();

include('conexion.php');

if(isset($_POST['Descripcion']) && isset($_POST['Cantidad']) && isset($_POST['Fecha'])){

    function validar($data){

        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $Descripcion = validar($_POST['Descripcion']);
    $Categoria = validar($_POST['Categoria']);
    $Cantidad = validar($_POST['Cantidad']);
    $Fecha = validar($_POST['Fecha']);

    $sql = "INSERT INTO gastos(Descripcion, Categoria, Cantidad, Fecha, id_usuario) VALUES('$Descripcion', '$Categoria', '$Cantidad', '$Fecha', '{$_SESSION['ID']}')";
    $query = $conexion->query($sql); 

    if($query){

        header("Location: ../Gastos.php");
        exit();
    }else{

        header("Location: ../Gastos.php?error=Ha ocurrido un error");
        exit();
    }
}
else{

    header("Location: ../Gastos.php");
    exit();
}
?>
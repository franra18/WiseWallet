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
    $Fecha = date('Y-m-d', strtotime(validar($_POST['Fecha'])));

    $Categoria_sql = "SELECT ID FROM categorias WHERE '$Categoria' = Nombre_Categoria";
    $categoria_result = $conexion->query($Categoria_sql);
    $categoria_row = $categoria_result->fetch_assoc();
    $Categoria_ID = $categoria_row['ID'];

    $sql = "INSERT INTO gastos(Descripcion, Categoría, Cantidad, Fecha, id_usuario) VALUES('$Descripcion', '$Categoria_ID', '$Cantidad', '$Fecha', '{$_SESSION['ID']}')";
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
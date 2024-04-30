<?php

//Variables de la conexión
$servidor       = "localhost";
$usuario        = "root";
$contraseña     = "";
$BD             = "wisewallet";

//Creando la conexión
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BD);

//Verificando conexión
if(!$conexion){
    die("Conection failed: " . mysqli_connect_error());
}

?>
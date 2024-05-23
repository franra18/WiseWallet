<?php
session_start();

include('php/conexion.php');

$id_usuario = $_SESSION['ID'];

$consulta = "SELECT * FROM gastos WHERE id_usuario = $id_usuario ORDER BY Fecha DESC";
$resultado = $conexion->query($consulta);
$Gastos = $resultado->fetch_all(MYSQLI_ASSOC);

$consulta2 = "SELECT * FROM categorias";
$resultado2 = $conexion->query($consulta2);
$Categorias = $resultado2->fetch_all(MYSQLI_ASSOC);
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiseWallet</title>
    <link rel="icon" type="image/png" href="logo.png"> <!--    Icono de la pestaña     -->
    <link rel="stylesheet" href="headerfooter.css"> <!--   Enlace con el archivo css     -->
    <link rel="stylesheet" href="Gastos2.css">
    <!-- Icono de la flecha hacia abajo e icono usuario -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<!--    Codigo Alpha Vantage: RKKRW3RKQQR6UBVE  -->

<body>
    <!--Asi se comenta en el html-->
    <!--        Menu        -->
    <div id="mysidenav" class="sidenav">
        <!--    Dropdown    -->
        <button class="dropdown-btn">Mi cuenta
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="Gastos.html">Subir</a>
            <a href="#">Buscar</a>
            <a href="#">Filtrar</a>
            <a href="#">Visualizar</a>
            <a href="#">Grupales</a>
            <a href="#">Historial</a>
            <a href="#">Exportar</a>
        </div>
        <!--    Enlaces     -->
        <a href="#">Objetivos</a>
        <a href="#">Progreso</a>
        <a href="#">Multimedia</a>
        <!--    Dropdown    -->
        <button class="dropdown-btn">Actualidad
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="#">Noticias</a>
            <a href="#">Mercado de <br> valores</a>
        </div>
    </div>
    <!--    Fin menu    -->

    <!--    CABECERA    -->
    <a href="iniciarsesion.php" class="logo">WiseWallet</a>
    <div class="header">

        <div class="iconomenu" onclick="myFunction(this), toggleNav()">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>

        <div class="header-right">
            <a href="sobrenosotros.html">Sobre nosotros</a> <!-- A la pagina que esté activa le añado class = "active" -->
            <a href="Perfil.php"><i class="fa fa-fw fa-user"></i>  Perfil</a>
        </div>
    </div>
    <!--    FIN CABECERA    -->

    <!--    CONTENIDO PRINCIPAL   -->

    <div class="Contenido">
        <div class="misgastos">
            <h1> Mis Gastos </h1>
        </div>

        <button id="MostrarIntroducirGasto" class="BotonGasto">Introducir Gasto</button>

        <form action="php/introducirgasto.php" method="POST" id="formulario" class="FormularioIntroducirGasto" style="display:none;">

            <?php if(isset($_GET['error'])){ ?>

                <h5 class="error">
                    <?php echo $_GET['error']?>
                </h5>
            <?php 
            }
            ?>

            <div class="cuadrostexto">
                <input type="text" name="Descripcion" placeholder="Descripcion" required>
                <input type="" name="Categoria" placeholder="Categoria">

                <div id="formularioCategoria" style="display:none;">
                    <?php
                        foreach($Categorias as $categoria) {
                        ?>

                            <input type="radio" name="categoria" value="<?php $categoria['Nombre_Categoria'] ?>"> <?php $categoria['Nombre_Categoria'] ?> <br>
                        <?php
                        }
                    ?>
                    <button id="btnSeleccionarCategoria">Seleccionar</button>
                </div>

                <input type="date" name="Fecha" placeholder="Fecha" required>
                <input type="number" name="Cantidad" placeholder="Cantidad" required>
            </div>
    
            <button type="submit" class="BotonGasto2">Enviar</button>
        </form>

        <?php

            $fecha_anterior = null;
    
            foreach($Gastos as $gasto) {

                $fecha_actual = date("d-m-Y", strtotime($gasto['Fecha']));
        
                if ($fecha_actual != $fecha_anterior) { ?>

                    <h5 class="Fecha"> <?php echo $fecha_actual?> </h5>
                <?php } ?>
            
            <div class="Gasto">
                <h1 class="Nombre_Gasto"> <?php echo $gasto['Descripcion']?> </h1>
                <h5 class="Categoria_Gasto"> <?php echo $gasto['Categoría']?> </h5>
                <h5 class="Cantidad_Gasto"> <?php echo $gasto['Cantidad']?> € </h5> 
            </div>
        <?php
        
            $fecha_anterior = $fecha_actual;
        }
    ?>
    </div>

    <!--    FIN CONTENIDO PRINCIPAL     -->

    <!--    PIE DE PAGINA    -->
    
    <!--    FIN PIE DE PAGINA    -->

    <!--    SCRIPTS     -->
    <script>
        function myFunction(x) {  // Animación del icono del menu
            x.classList.toggle("change");
        }

        function toggleNav() {  // Hace que el icono del menu pueda abrir y cerrar el sidenav
            const sidenav = document.getElementById("mysidenav");
            const container = document.querySelector(".iconomenu");
            const submenu1 = document.querySelector(".sidenav .dropdown-container:nth-of-type(1)");
            const submenu2 = document.querySelector(".sidenav .dropdown-container:nth-of-type(2)");
            const opcionactiva1 = document.querySelector(".sidenav .opcionactiva:nth-of-type(1)");
            const opcionactiva2 = document.querySelector(".sidenav .opcionactiva:nth-of-type(2)");

            if (sidenav.style.width === "200px") {
                sidenav.style.width = "0";
                container.classList.remove("change");

                //Ocultar submenus
                submenu1.style.display = "none";
                submenu2.style.display = "none";

                //Eliminar clase "opcionactiva"
                opcionactiva1.classList.toggle("opcionactiva");
                opcionactiva2.classList.toggle("opcionactiva");

            } else {
                sidenav.style.width = "200px";
                container.classList.add("change");
            }
        }

        //DROPDOWN
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("opcionactiva");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }

        document.getElementById("MostrarIntroducirGasto").addEventListener("click", function() {

            var formulario = document.getElementById("formulario");
            if (formulario.style.display === "block") {
                formulario.style.display = "none";
            } else {
                formulario.style.display = "block";
            }
        });

        var formularioCategoria = document.getElementById("formularioCategoria");
        var btnSeleccionarCategoria = document.getElementById("btnSeleccionarCategoria");
        var inputCategoria = document.getElementsByName("Categoria")[0];

        // Mostrar el formulario de categoría al hacer clic en el campo de categoría
        inputCategoria.addEventListener("click", function() {
            formularioCategoria.style.display = "block";
        });

        // Manejar la selección de categoría y ocultar el formulario de categoría
        btnSeleccionarCategoria.addEventListener("click", function() {
            var categoriaSeleccionada = document.querySelector('input[name="categoria"]:checked').value;
            inputCategoria.value = categoriaSeleccionada;
            formularioCategoria.style.display = "none";
        });
    </script>
    <!--    FIN SCRIPTS     -->
</body>

</html>
<?php
session_start();

include('php/conexion.php');

$id_usuario = $_SESSION['ID'];

$filtro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = isset($_POST['filtro_categoria']) ? $_POST['filtro_categoria'] : '';
    $fecha_desde = isset($_POST['fechadesde']) ? $_POST['fechadesde'] : '';
    $fecha_hasta = isset($_POST['fechahasta']) ? $_POST['fechahasta'] : '';

    if ($fecha_desde !== '') {
        $fecha_desde = date('Y-m-d', strtotime($fecha_desde));
    }
    if ($fecha_hasta !== '') {
        $fecha_hasta = date('Y-m-d', strtotime($fecha_hasta));
    }

    if ($categoria !== '') {
        $filtro .= "AND categorias.Nombre_Categoria = '$categoria' ";
    }

    if ($fecha_desde !== '' && $fecha_hasta === '') {
        $filtro .= "AND gastos.Fecha >= '$fecha_desde' ";
    } elseif ($fecha_desde === '' && $fecha_hasta !== '') {
        $filtro .= "AND gastos.Fecha <= '$fecha_hasta' ";
    } elseif ($fecha_desde !== '' && $fecha_hasta !== '') {
        $filtro .= "AND gastos.Fecha BETWEEN '$fecha_desde' AND '$fecha_hasta' ";
    }
}

$consulta = "SELECT gastos.*, categorias.Nombre_Categoria 
             FROM gastos 
             JOIN categorias ON gastos.Categoría = categorias.ID 
             WHERE gastos.id_usuario = $id_usuario $filtro 
             ORDER BY gastos.Fecha DESC";

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
    <link rel="stylesheet" href="gastos.css">
    <!-- Icono de la flecha hacia abajo e icono usuario -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr Theme CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</head>

<body>
    <!--Asi se comenta en el html-->
    <!--        Menu        -->
    <div id="mysidenav" class="sidenav">
    <a href="index.html">Inicio</a>
        <!--    Dropdown    -->
        <button class="dropdown-btn">Mi cuenta
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="Perfil.php">Perfil</a>
            <a href="#">Cuentas y </br> tarjetas</a>
            <a href="suscripciones.html">Suscripciones</a>
        </div>
        <!--    Dropdown    -->
        <button class="dropdown-btn">Gastos
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="Gastos.php">Mis Gastos</a>
            <a href="#">Grupales</a>
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
    <a href="index.html" class="logo">WiseWallet</a>
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
                <input type="text" name="Descripcion" autocomplete="off" placeholder="Descripcion" required>

                <select name="Categoria" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php foreach($Categorias as $categoria) { ?>

                        <option value="<?php echo $categoria['Nombre_Categoria'] ?>"><?php echo $categoria['Nombre_Categoria'] ?></option>
                    <?php } ?>
                </select>

                <input type="text" name="Fecha" id="FechaInputGasto" placeholder="Fecha" class="flatpickr-input" required>

                <input type="number" name="Cantidad" placeholder="Cantidad" required>
            </div>
    
            <button type="submit" class="BotonGasto2">Enviar</button>
        </form>

        <form method="POST" action="Gastos.php">
            <div class="Filtro">

                Filtros
                <div class="filtro_categoria">
                
                    Categoria
                    <select name="filtro_categoria">

                        <option value="" disabled selected>Selecciona una categoría</option>
                            <?php foreach($Categorias as $categoria) { ?>

                                <option value="<?php echo $categoria['Nombre_Categoria'] ?>"><?php echo $categoria['Nombre_Categoria'] ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="filtro_fecha1">
                
                    Fecha desde:
                    <input type="text" name="fechadesde" id="FechaInputDesde" placeholder="Seleccionar fecha" class="flatpickr-input">
                </div>
                <div class="filtro_fecha2">
                
                    Fecha hasta:
                    <input type="text" name="fechahasta" id="FechaInputHasta" placeholder="Seleccionar fecha" class="flatpickr-input">
                </div>

                <input type="submit" value="Aplicar" class="BotonFiltrar">
            </div>
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
                <h5 class="Categoria_Gasto"> <?php echo $gasto['Nombre_Categoria']?> </h5>
                <h5 class="Cantidad_Gasto"> <?php echo $gasto['Cantidad']?> € </h5> 
            </div>
        <?php
        
            $fecha_anterior = $fecha_actual;
        }
    ?>
    </div>
    <!--    FIN CONTENIDO PRINCIPAL     -->

    <!--    PIE DE PAGINA    -->
    <div class="footer">
        <div class="centrarenlaces">
            <a href="#">Política de privacidad</a>
            <a href="#">Aviso legal</a>
            <a href="#">Cookies</a>
            <a href="#">Contacto</a>
        </div>
    </div>
    <!--    FIN PIE DE PAGINA    -->

    <!--    SCRIPTS     -->
    <script>
        function myFunction(x) {  // Animación del icono del menu
            x.classList.toggle("change");
        }

        function toggleNav() {  // Hace que el icono del menu pueda abrir y el sidenav
            const sidenav = document.getElementById("mysidenav");
            const container = document.querySelector(".iconomenu");

            if (sidenav.style.width === "200px") {
                sidenav.style.width = "0";
                container.classList.remove("change");
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

        const fpGasto = flatpickr("#FechaInputGasto", {
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "F j, Y",
            locale: "es",
            allowInput: true,
        });

        const fpDesde = flatpickr("#FechaInputDesde", {
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "F j, Y",
            locale: "es",
        });

        const fpHasta = flatpickr("#FechaInputHasta", {
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "F j, Y",
            locale: "es",
        });

        window.addEventListener('scroll', () => {
            if (fpGasto.isOpen) fpGasto.close();
            if (fpDesde.isOpen) fpDesde.close();
            if (fpHasta.isOpen) fpHasta.close();
        });
    </script>
    <!--    FIN SCRIPTS     -->
</body>

</html>
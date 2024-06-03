<?php
session_start();

include('php/conexion.php');

$Correo = $_SESSION['Correo'];
$Contraseña = $_SESSION['Contraseña'];
$Nombre = $_SESSION['Nombre'];
$Apellidos = $_SESSION['Apellidos'];
$Imagen = $_SESSION['Imagen'];
if ($_SESSION['FechaNac'] !== NULL) {
    $FechaNac = date("d-m-Y", strtotime($_SESSION['FechaNac']));
}else{

    $FechaNac = null;
}
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiseWallet</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="headerfooter.css">
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

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
            <a href="#"><i class="fa fa-fw fa-user"></i>  Perfil</a>
        </div>
    </div>
    <!--    FIN CABECERA    -->

    <div class="Datos-perfil">

        <div class="Imagen-perfil">
            <?php if($Imagen !== null){ ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['Imagen']); ?>" alt="Foto de perfil">
            <?php } else { ?>
                <img src="default.webp">
            <?php } ?>
        </div>
        
        <h4 class="Nombre">
            <?php echo $Nombre . ' ' . $Apellidos?>
        </h4>
        <div class="Datos">
            <h4>
                <?php echo 'Correo: ' . $Correo?>
            </h4>
            <h4>
                Contraseña: <span id="password"></span>
                <button id="togglePassword" style="background:none; border:none"><i id="eyeIcon" class="fa fa-eye"></i></button>
            </h4>
            <h4>
                <?php if($FechaNac !== null){ 
                    echo 'Fecha de Nacimiento: ' . $FechaNac;
                } else { 
                    echo 'Fecha de Nacimiento: Sin Fecha Seleccionada.';
                } ?>
                <form action="php/EditarDatos.php" method="post" class="Editar">
                    <label for="fecha">Editar: </label>
                    <input type="date" id="fecha" name="fecha" class="Editar_fech" required>
                    <input type="submit" value="Enviar" class="Editar_env">
                </form>
            </h4>
        </div>
        <form action="php/CerrarSesion.php" method="post">
            <input type="submit" value="Cerrar Sesion" name="Cerrar_Cuenta" class="boton-CerrarSesion"></input>
        </form>
        <form action="php/BorrarFoto.php" method="post">
            <input type="submit" name="borrar_foto" value="Eliminar Foto de Perfil" class="boton-BorrarFoto">
        </form>
        <form action="php/CambiarFoto.php" method="post" enctype="multipart/form-data" style="display: flex; align-items: flex-start;">
            <input type="submit" name="cambiar_foto" value="Cambiar Foto de Perfil" class="boton-CambiarFoto">
            <label for="Foto_Perfil" class="boton-personalizado" style="margin-left: 0;"><i class="fa fa-upload"></i></label>
            <input type="file" name="Foto_Perfil" id="Foto_Perfil" style="display:none;" accept="image/*" onchange="updateFileName(this)" required>
            <span id="file-name" style="margin-left: 10px; margin-top:11px; font-family:Fuente1;"></span>
        </form>

    </div>

    <div class="footer">
        <div class="centrarenlaces">
            <a href="#">Política de privacidad</a>
            <a href="#">Aviso legal</a>
            <a href="#">Cookies</a>
            <a href="#">Contacto</a>
        </div>
    </div>
    
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

        function updateFileName(input) {
            var fileName = input.files[0].name;
            document.getElementById('file-name').textContent = "Archivo seleccionado: "+fileName;
        }

        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordSpan = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordButton.addEventListener('click', function() {
            if (passwordSpan.textContent !== '') {
                passwordSpan.textContent = '';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordSpan.textContent = '<?php echo $Contraseña?>';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });

    </script>
</body>
</html>
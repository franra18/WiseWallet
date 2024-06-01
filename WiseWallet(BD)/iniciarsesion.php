<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiseWallet</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="iniciarsesion.css">
    <link rel="stylesheet" href="headerfooter.css">
</head>

<body>
    <!--Asi se comenta en el html-->

    <!--    CABECERA    -->
    <div class="login">
        <div class="header">
            <a href="registrarse.php" class="logo_iniciar">WiseWallet</a>
            <div class="header-right">
                <!-- A la pagina que esté activa le añado class = "active" -->
                <a href="sobrenosotros.html">Sobre nosotros</a>
            </div>
        </div>
    </div>
    <!--    FIN CABECERA    -->

    <!--    CONTENIDO PRINCIPAL   -->
    <div class="fondoiniciarsesion">
        <div class="login">
            <h1 class="tituloinicia">Inicia sesión</h1>
            <h5>¿No tienes cuenta? <a href="registrarse.php" class="texto-registra">Regístrate</a></h5>

            <form action="php/IniciarSesion.php" method="post">
                <?php
                    if(isset($_GET['error'])){
                        ?>
                        <h4 class="error">
                            <?php echo $_GET['error']?>
                        </h4>
                <?php
                    }
                ?>
                <div class="cuadrostexto">
                    <input type="email" name="Correo" placeholder="Correo electrónico" required>
                    <input type="password" name="Contraseña" placeholder="Contraseña" required>
                </div>

                <label class="custom-checkbox">Recuérdame
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <input type="submit" value="Iniciar sesión" class="botonregistro"></input>
            </form>
        </div>
    </div>
    <!--    FIN CONTENIDO PRINCIPAL     -->


</body>

</html>
<?php
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/inicioSesion.css";
    include("pl_encabezado.php");
    //Errores
    foreach ($errores as $key => $value) {
        echo "Error en el campo $key <br>";
    }
?>
<style>
    .div-popup--mostrar{
        display: block;
    }
    .div-popup--ocultar{
        display: none;
    }
</style>
    <script>
    function mostrarOcultar(){
        event.preventDefault();
        var btn = this;
        var popup = document.getElementsByClassName("div-popup")[0];
        if (popup.classList.contains("div-popup--mostrar")) {
            popup.classList.replace("div-popup--mostrar","div-popup--ocultar");
        }else if (popup.classList.contains("div-popup--ocultar")) {
            popup.classList.replace("div-popup--ocultar","div-popup--mostrar");
        }
    }
    //Onload
    window.onload = function(){
        document.getElementById("bSignIn").addEventListener("click", mostrarOcultar, false);
    }
    </script>
    <h1>Services</h1>
    <form action="" method="POST">
        <div id="div-signInUp">
            <label for="bSignIn"></label>
            <input type="submit" id="bSignIn" value="Sign in" name="bSignIn">

            <a href="formRegistro.php">Sign Up</a>
            </div>
        <div class="div-popup div-popup--ocultar">
            <div id="div-email">
                <label for="email"></label>
                Email <input type="text" id="email" name="email"><br>
            </div>

            <div id="div-password">
                <label for="password"></label>
                Password <input type="password" id="password" name="password"><br>
            </div>
            <label for="bEnter"></label>
            <input type="submit" id="bEnter" value="Enter" name="bEnter">
        </div>
    </form>
<?php
    //Pie
    include("pl_pie.html");
?>
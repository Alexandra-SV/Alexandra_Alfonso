<?php
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../../css/inicioSesion.css";
    include("pl_encabezado.php");
?>
    <h1>Services</h1>
    <form action="" method="POST">
        <div id="div-signInUp">
            <label for="bSignIn"></label>
            <input type="submit" id="bSignIn" value="Sign in" name="bSignIn">

            <label for="bSignUp"></label>
            <input type="button" id="bSignUp" value="Sign Up" name="bSignUp">
            </div>
        <div id="div-popup">
            <div id="div-email">
                <label for="email"></label>
                Email <input type="text" id="email" name="email"><br>
            </div>

            <div id="div-password">
                <label for="password"></label>
                Password <input type="text" id="password" name=""><br>
            </div>
            <label for="bEnter"></label>
            <input type="button" id="bEnter" value="Enter" name="bEnter">
    </form>
    <a href="">Sign up</a>
<?php
    //Pie
    include("pl_pie.html");
?>
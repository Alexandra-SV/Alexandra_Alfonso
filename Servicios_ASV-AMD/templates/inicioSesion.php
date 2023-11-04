<?php
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../../css/inicioSesion.css";
    include("pl_encabezado.php");
?>
    <h1>Services</h1>
    <form action="" method="POST">
        <label for="email"></label>
        Email <input type="text" id="email" name="email"><br>

        <label for="password"></label>
        Password <input type="text" id="password" name=""><br>

        <label for="bSignIn"></label>
        <input type="submit" id="bSignIn" value="Sign in" name="bSignIn">

        <label for="bEnter"></label>
        <input type="button" id="bEnter" value="Enter" name="bEnter">
    </form>
    <a href="">Sign up</a>
<?php
    //Pie
    include("pl_pie.html");
?>
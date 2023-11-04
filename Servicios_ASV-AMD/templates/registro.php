<?php
    //Encabezado
    $titulo = "Register";
    $css = "../css/registro.css";
    include("pl_encabezado.php");
?>
    <h1>Services</h1>
    <form action="" method="POST">
        <label for="fullName"></label>
        Full name <input type="text" id="fullName" name="fullName"><br>

        <label for="email"></label>
        Email <input type="text" id="email" name="email"><br>

        <label for="password"></label>
        Password <input type="text" id="password" name="password"><br>

        <label for="confirmPassword"></label>
        Confirm password <input type="text" id="confirmPassword" name="confirmPassword"><br>

        <label for="dateOfBirth"></label>
        Date of birth <input type="text" id="dateOfBirth" name="dateOfBirth"><br>

        <label for="profilePicture"></label>
        Profile picture<input type="file" id="profilePicture" name="profilePicture"><br>

        <!--select idiomas-->

        <label for="description"></label>
        Description <input type="textbox" id="description"name="description"><br>

        <label for="bRegister"></label>
        <input type="submit" id="bRegister"name="bRegister" value="Save">
    </form>
<?php
    //Pie
    include("pl_pie.html");
?>
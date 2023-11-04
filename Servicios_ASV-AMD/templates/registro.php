<?php
    //Encabezado
    $titulo = "Register";
    $css = "../css/registro.css";
    include("pl_encabezado.php");
    //Errores
    foreach ($errores as $key) {
        echo "Error en el campo $key <br>";
    }
?>
    <h1>Services</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="fullName"></label>
        Full name <input type="text" id="fullName" name="fullName"><br>

        <label for="email"></label>
        Email <input type="text" id="email" name="email"><br>

        <label for="password"></label>
        Password <input type="password" id="password" name="password"><br>

        <label for="dateOfBirth"></label>
        Date of birth <input type="date" id="dateOfBirth" name="dateOfBirth" min="1950-01-01" max="2023-09-01" /><br>

        <label for="profilePicture"></label>
        Profile picture<input type="file" id="profilePicture" name="profilePicture"><br>

        <label for="languages"></label>
        Languages
        <?php pintaSelect($languagesArray,'languages') ;?>
        <br>

        <label for="description"></label>
        Description <textarea id="description"name="description"></textarea><br>

        <label for="bRegister"></label>
        <input type="submit" id="bRegister"name="bRegister" value="Save">
    </form>
    <a href="formInicioSesion.php">To main page</a>
<?php
    //Pie
    include("pl_pie.html");
?>
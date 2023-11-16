<?php
    //Encabezado
    $titulo = "Register";
    $css = "../css/registro.css";
    include("pl_encabezado.php");
?>
    <div class="container">
        <a href="formInicioSesion.php">< To main page</a>
        <h1>Sign Up</h1>
        <div></div>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="fullName"></label>
        Full name <input type="text" id="fullName" name="fullName" size="30"><br>
        <?php
            echo (isset($errores['fullName'])) ? "<span class=\"error\">".$errores['fullName']."</span><br>" : "";
        ?>
        <label for="email"></label>
        Email <input type="text" id="email" name="email" size="30"><br>
        <?php
            echo (isset($errores['email'])) ? "<span class=\"error\">".$errores['email']."</span><br>" : "";
        ?>

        <label for="password"></label>
        Password <input type="password" id="password" name="password" size="30"><br>
        <?php
            echo (isset($errores['password'])) ? "<span class=\"error\">".$errores['password']."</span><br>" : "";
        ?>

        <label for="dateOfBirth"></label>
        Date of birth <input type="date" id="dateOfBirth" name="dateOfBirth" min="1950-01-01" max="2005-01-01"  size="30"/><br>
        <?php
            echo (isset($errores['dateOfBirth'])) ? "<span class=\"error\">".$errores['dateOfBirth']."</span><br>" : "";
        ?>

        <label for="profilePicture"></label>
        Profile picture<input type="file" id="profilePicture" name="profilePicture"><br>

        <label for="languages"></label>
        Languages <br>
        <?php pintaSelect($languagesArray,'languages') ;?>
        <br>

        <label for="description"></label>
        Description<br><textarea id="description"name="description" rows="5"cols="50"></textarea><br>

        <label for="bRegister"></label>
        <input type="submit" id="bRegister"name="bRegister" value="Save">
    </form>
<?php
    //Pie
    include("pl_pie.html");
?>
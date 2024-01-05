<?php
    //Encabezado
    $titulo = "Register";
    $css = "../css/registro.css";
    include("pl_encabezado.php");
?>
    <?php
        echo (isset($errores['insert'])) ? "<span class=\"error\">".$errores['insert']."</span><br>" : "";
    ?>
    <div class="container">
        <a href="formInicioSesion.php">< To main page</a>
        <h1>Sign Up</h1>
        <div></div>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="fullName">Full name*</label>
         <input type="text" id="fullName" name="fullName"><br>
        <?php
            echo (isset($errores['fullName'])) ? "<span class=\"error\">".$errores['fullName']."</span><br>" : "";
        ?>
        <label for="email">Email*</label>
         <input type="text" id="email" name="email"><br>
        <?php
            echo (isset($errores['email'])) ? "<span class=\"error\">".$errores['email']."</span><br>" : "";
        ?>

        <label for="password">Password*</label>
         <input type="password" id="password" name="password"><br>
        <?php
            echo (isset($errores['password'])) ? "<span class=\"error\">".$errores['password']."</span><br>" : "";
        ?>

        <label for="dateOfBirth">Date of birth*</label>
         <input type="date" id="dateOfBirth" name="dateOfBirth"/><br>
        <?php
            echo (isset($errores['dateOfBirth'])) ? "<span class=\"error\">".$errores['dateOfBirth']."</span><br>" : "";
        ?>

        <label for="profilePicture">Profile picture</label>
        <input type="file" id="profilePicture" name="profilePicture"><br>
        <?php
            echo (isset($errores['profilePicture'])) ? "<span class=\"error\">".$errores['profilePicture']."</span><br>" : "";
        ?>

        <label for="languages"> Languages</label>
        <br>
        <?= pintaSelect($languagesArray,"languages");?>
        <br>
        <?php
            echo (isset($errores['languages'])) ? "<span class=\"error\">".$errores['languages']."</span><br>" : "";
        ?>

        <label for="description">Description</label>
        <br><textarea id="description"name="description" rows="5"cols="50"></textarea><br>
        <label for="bRegister"></label>
        <input type="submit" id="bRegister"name="bRegister" value="Save">
    </form>

    <script>
        window.onload=function(){
            document.getElementById('fondo').addEventListener('change',color,false);
        };
        function color(){
            var c=this[this.selectedIndex].value;
            document.body.style.background=c;
        }
    </script>
<?php
    //Pie
    include("pl_pie.html");
?>
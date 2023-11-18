<?php
$titulo="ModifyUser";
$css="../css/ModifUsuario.css";
include("../templates/pl_encabezado.php");
include("../libs/bComponentes.php");

$user = $_SESSION['active'];
$userData=userData("../ficheros/usuarios.txt", $user,"GetDataUser", $errores);
    if($user == ""){
        header('location:../forms/formInicioSesion.php');
    }
?>

    <header><a href="../forms\form_mainpage.php">&#60; To main page</a><h1>Services-Usuario</h1></header><!--Redirige a inicio -->
    <main>
        <form action="" method="POST" id="form-usuario" enctype="multipart/form-data">
        <section id="s1">
        <div>
            <label for="nombreCompleto">Full Name*</label>
                <span name="nombreCompleto" id="nombreCompleto"> <?=$userData[2]?></span>
        </div>
        <div>
            <label for="email">Email*</label>
                <span name="email" id="email" ><?=$userData[0]?></span>
        </div>
        <div>
            <label for="Password">Password*</label>
                <input type="password" name="password" id="Password">
                <?php
                    echo (isset($errores['password'])) ? "<span class=\"error\">".$errores['password']."</span><br>" : "";
                ?>
        </div>
        <div>
            <label for="date">Date of Birth*</label>
                <span name="date" id="date" ><?=$userData[3]?></span>
        </div>
        <div><label for="languages">Languages</label><br>
                <?=pintaSelect($languagesArray,"languages");?>
                <?php
                    echo (isset($errores['languages'])) ? "<span class=\"error\">".$errores['languages']."</span><br>" : "";
                ?>
        </div>
        <div>
            <label for="descripcionPersonal"> Personal description</label><br>
                <textarea name="descripcionPersonal" id="descripcionPersonal"><?=$userData[6]?></textarea>
                <?php
                    echo (isset($errores['descripcionPersonal'])) ? "<span class=\"error\">".$errores['descripcionPersonal']."</span><br>" : "";
                ?>
        </div>
            <input type="submit" name="bSave" id="save" value="S A V E">
        </section>
        <section id="div-image">
            <span>Profile picture</span>
                <br>
            <img src="<?=$userData[4]?>" alt="profPicture">
                <br>
            <label for="boton">Select a file</label>
                <input type="file" name="imagen" value="imagen-perfil" id="boton" >
                <?php
                    echo (isset($errores['imagen'])) ? "<span class=\"error\">".$errores['imagen']."</span><br>" : "";
                ?>
        </section>
        </form>
    </main>

<?include("./pl_pie.html");?>
<script>
    window.onload = function () {
        var addImagen = document.getElementById("boton");
        addImagen.addEventListener("change", changePicture, false);
    }

    function changePicture(event) {
        var input = event.target;
        var img = input.previousElementSibling.previousElementSibling.previousElementSibling;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
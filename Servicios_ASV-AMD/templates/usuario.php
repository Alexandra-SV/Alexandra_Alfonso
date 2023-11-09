<?php
$titulo="ModifyUser";
$css="../css/ModifUsuario.css";
include("../templates/pl_encabezado.php");
include("../libs/bComponentes.php");

$user = $_SESSION['active'];
    if($user == ""){
        header('location:../forms/formInicioSesion.php');
    }

?>

    <header><a href="../forms\form_mainpage.php">&#60; To main page</a><h1>Services-Usuario</h1></header><!--Redirige a inicio -->
    <main>
        <form action="" method="POST" id="form-usuario" enctype="multipart/form-data">
        <div>
            <label for="nombreCompleto">Full Name*</label>
            <input type="text" name="nombreCompleto" id="nombreCompleto" value="<?=$_SESSION['usuarios'][$user]['fullName']?>" readonly />
        </div>
        <div>
            <label for="email">Email*</label>
            <input type="text" name="email" id="email" value="<?=$_SESSION['usuarios'][$user]['email']?>" readonly>
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
            <input type="text" name="date" id="date" value="<?=$_SESSION['usuarios'][$user]['dateOfBirth']?>" readonly>
        </div>
        <div><label for="languages">Languages</label>
             <?=pintaSelect($languagesArray,"languages");?>
             <?php
                echo (isset($errores['languages'])) ? "<span class=\"error\">".$errores['languages']."</span><br>" : "";
            ?>
        </div>
        <div>
            <label for="descripcionPersonal"> Personal description</label><br>
            <textarea name="descripcionPersonal" id="descripcionPersonal"><?=$_SESSION['usuarios'][$user]['description']?></textarea>
            <?php
                echo (isset($errores['descripcionPersonal'])) ? "<span class=\"error\">".$errores['descripcionPersonal']."</span><br>" : "";
            ?>
        </div>
            <input type="submit" name="bSave" id="save" value="S A V E">

        <div id="div-image">
        <span>Profile picture</span>
            <br>
            <?php
                if($_SESSION['usuarios'][$user]['profilePicture'] != 1){
                    echo "<img height=\"50\"width=\"50\"src=\"".$_SESSION['usuarios'][$user]['profilePicture']."\" alt=\"profPicture\">";
                }else{
                    echo "<img height=\"50\"width=\"50\"src=\"../img/imgPerfil/default_picture_donotdelete.jpg\" alt=\"profPicture\">";
                }
            ?>
            <br>
            <label for="boton">Select a file</label>
            <input type="file" name="imagen" value="imagen-perfil" id="boton" >
            <?php
                echo (isset($errores['imagen'])) ? "<span class=\"error\">".$errores['imagen']."</span><br>" : "";
            ?>
        </div>
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
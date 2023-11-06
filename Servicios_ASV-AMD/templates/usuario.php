<?php
if(!isset($_SESSION)) session_start();
$titulo="ModifyUser";
$css="../css/ModifUsuario.css";
include("../templates/pl_encabezado.php");
include("../libs/bComponentes.php");

$user = recoge('user');
    if($user == ""){
        header('location:../forms/formInicioSesion.php');//devuelve a inicio cuando le das a la foto
    }

?>

    <header><a href="../forms\form_mainpage.php?user=<?=$user?>">&#60; To main page</a><h1>Services-Usuario</h1></header><!--Redirige a inicio -->
    <main>
        <form action="" method="POST" id="form-usuario">
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
            <input type="text" name="password" id="Password">
            <?php
                echo (isset($errores['password'])) ? "<span class=\"error\">".$errores['password']."</span><br>" : "";
            ?>
        </div>
        <div>
            <label for="date">Date of Birth*</label>
            <input type="text" name="date" id="date" value="<?=$_SESSION['usuarios'][$user]['dateOfBirth']?>" readonly>
        </div>
        <div><?=pintaSelect($languagesArray,"languages");?></div>
        <div>
            <label for="descripcionPersonal"> Personal  Personal description</label>
            <textarea name="descripcionPersonal" id="descripcionPersonal"><?=$_SESSION['usuarios'][$user]['description']?></textarea>
            <?php
                echo (isset($errores['descripcionPersonal'])) ? "<span class=\"error\">".$errores['imagdescripcionPersonalen']."</span><br>" : "";
            ?>
        </div>
            <input type="submit" name="bSave" id="save" value="S A V E">
        </form>
        <form action="" method="POST" enctype="multipart/form-data">
        <span>Profile picture</span>
            <br>
            <img src="<?=$_SESSION['usuarios'][$user]['profilePicture']?>" alt="<?=$_SESSION['usuarios'][$user]['profilePicture']?>">
            <br>
            <label for="boton">Select a file</label>
            <input type="file" name="imagen" value="imagen-prfil" id="boton">
            <?php
                echo (isset($errores['imagen'])) ? "<span class=\"error\">".$errores['imagen']."</span><br>" : "";
            ?>
        </form>
    </main>

<?include("./pl_tie.html");?>

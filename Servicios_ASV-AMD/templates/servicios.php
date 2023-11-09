<?php
$titulo="Add Service ";
$css="../css/servicios.css";

include("../templates/pl_encabezado.php");
include("../libs/bComponentes.php");
?>
    <header><a href="../forms/form_mainpage.php"> &#60; To main page</a><h1>Services-services</h1></header><!--Redirige a inicio -->
    <main>
        <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="titulo">Title*</label>
            <input type="text" name="titulo" id="titulo" />
            <?php
                echo (isset($errores['titulo'])) ? "<span class=\"error\">".$errores['titulo']."</span><br>" : "";
            ?>
        </div>
        <div><label for="category">Category</label><?= pintaSelect($category,"category");?>
            <?php
                echo (isset($errores['category'])) ? "<span class=\"error\">".$errores['category']."</span><br>" : "";
            ?>
        </div>
        <div id="radio"><label for="tipo">Type</label><?= pintaRadio($type, "tipo");?>
            <?php
                echo (isset($errores['tipo'])) ? "<span class=\"error\">".$errores['tipo']."</span><br>" : "";
            ?>
        </div>
        <div>
            <label for="ubicacion">Location*</label>
            <input type="text" name="ubicacion" id="ubicacion" >
            <?php
                echo (isset($errores['ubicacion'])) ? "<span class=\"error\">".$errores['ubicacion']."</span><br>" : "";
            ?>
        </div>
        <div><label for="Availability">Availability</label><?= pintaSelect($Availability,"Availability");?>
            <?php
                echo (isset($errores['Availability'])) ? "<span class=\"error\">".$errores['Availability']."</span><br>" : "";
            ?>
        </div>
        <div>
            <label for="precioH">Price per hour</label>
            <input type="text" name="precioH" id="precioH">
            <?php
                echo (isset($errores['precioH'])) ? "<span class=\"error\">".$errores['precioH']."</span><br>" : "";
            ?>
        </div>
        <div id="addfile">
            <span>Service picture</span>
            <label for="servicePicture">Choose file</label>
            <input type="file" id="servicePicture" name="servicePicture">
            <?php
                echo (isset($errores['servicePicture'])) ? "<span class=\"error\">".$errores['servicePicture']."</span><br>" : "";
            ?>
        </div>
        <div>
        <label for=" servicedescription"> Service description</label><br>
            <textarea name="servicedescription" id="servicedescription"></textarea>
            <?php
                echo (isset($errores['servicedescription'])) ? "<span class=\"error\">".$errores['servicedescription']."</span><br>" : "";
            ?>
        </div>
            <input type="submit" name="bSave" id="bSave" value="S A V E">
        </form>
    </main>
<?include("./pl_pie.html");?>

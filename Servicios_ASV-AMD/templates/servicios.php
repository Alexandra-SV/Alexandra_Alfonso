<?php 
if(!isset($_SESSION)) session_start();
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
        </div>
        <div>Category<?= pintaSelect($category,"category");?></div><!--Para de ejecutar el codigo aqui Undefined variable $category -->
        <div id="radio">Type<?= pintaRadio($type, "tipo");?></div>
        <div>
            <label for="ubicacion">Location*</label>
            <input type="text" name="ubicacion" id="ubicacion" >
        </div>
        <div>Availability<?= pintaSelect($Availability,"Availability");?></div>
        <div>
            <label for="precioH">Price per hour</label>
            <input type="text" name="precioH" id="precioH">
        </div>
        <div id="addfile">
            <span>Service picture</span>
            <label for="servicePicture">Choose file</label>
            <input type="file" id="servicePicture" name="servicePicture">
        </div>
        <div>
        <label for=" servicedescription"> Service description</label>
            <textarea name="servicedescription" id="servicedescription"></textarea>
        </div>
            <input type="submit" name="bSave" id="bSave" value="S A V E">
        </form>
    </main>
<?include("./pl_tie.html");?>

<?$titulo="ModifyUserForm";
$css="Servicios_ASV-AMD\css\ModifUsuario.css";
include("./pl_encabezado.php");
include("../libs/bComponentes.php");?>
    <header><a href="..\forms\formpaginaPrincipal\form_mainpage.php"> &#60; To main page</a><h1>Services</h1></header>
    <main>
        <form action="" method="POST" enctype="multipart/form-data">   
        <div>
            <label for="titulo">Title*</label>
            <input type="text" name="titulo" id="titulo" />
        </div>
        <div><?= pintaSelect($category,"category");?></div>
        <div><?= pintaRadio($type, "tipo");?></div>
        <div>
            <label for="ubicacion">Location*</label>
            <input type="text" name="ubicacion" id="ubicacion" >
        </div>
        <div><?= pintaSelect($Availability,"Availability");?></div>
        <div>
            <label for="precioH">Price per hour</label>
            <input type="text" name="precioH" id="precioH">
        </div>
        <div>
            <label for="servicePicture">Service Picture</label>
            <input type="file" id="servicePicture" name="servicePicture">
        </div>
        <div>
            <label for="descripcionPersonal"> Personal</label>
            <input type="textbox" name="descripcionPersonal" id="descripcionPersonal" >
        </div>
            <input type="submit" name="bSave" id="bSave" value="S A V E">
        </form>
    </main>
<?include("./templates/pl_tie.html");?>
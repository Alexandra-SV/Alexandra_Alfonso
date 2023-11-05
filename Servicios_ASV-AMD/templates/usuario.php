<?$titulo="ModifyUserForm";
$css="Servicios_ASV-AMD\css\ModifUsuario.css";
include("../../templates/pl_encabezado.php");
include("../../libs/bComponentes.php");?>
    <header><a href="..\forms\formpaginaPrincipal\form_mainpage.php">&#60; To main page</a><h1>Services</h1></header>
    <main>
        <form action="" method="POST" >   
        <div>
            <label for="nombreCompleto">Full Name*</label>
            <input type="text" name="nombreCompleto" id="nombreCompleto" value="<?=$_SESSION['usuarios']['email']['nombre']?>" readonly />
        </div>
        <div>
            <label for="email">Email*</label>
            <input type="text" name="email" id="email" value="<?$_SESSION['usuarios']['email']['email']?>" readonly>
        </div>
        <div> 
            <label for="Password">Password*</label>
            <input type="text" name="Password" id="Password">
        </div>
        <div>
            <label for="date">Date of Birth*</label>
            <input type="text" name="date" id="date" value="<?=$date?>" readonly>
        </div>
        <div><?=pintaSelect($idiomas,"Lenguages");?></div>
        <div>
            <label for="descripcionPersonal"> Personal</label>
            <input type="textbox" name="descripcionPersonal" id="descripcionPersonal" value="<?=$_SESSION['usuarios']['email']['descripcion']?>" >
        </div>
            <input type="submit" name="bSave" id="save" value="S A V E">
        </form>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="">Profile picture</label>
            <br>
            <img src="<?=$_SESSION['usuarios']['email']['imagen']?>" alt="<?=$_SESSION['usuarios']['email']['imagen']?>">
            <br>
            <input type="file" name="imagen" value="<?= isset($imagen)?$imagen: "";?>">
        </form>
    </main>
    
<?include("../../templates/pl_tie.html");?>

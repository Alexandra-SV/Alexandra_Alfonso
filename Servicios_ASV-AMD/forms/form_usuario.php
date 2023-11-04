<?$titulo="ModifyUserForm";
$css="Servicios_ASV-AMD\css\ModifUsuario.css";
include("../templates/pl_encabezado.php");?>

    <header><a href="./form_mainpage.php"> To main page</a><h1>Services</h1></header>
    <main>
        <form action="" method="POST" >   
        <div>
            <label for="nombreCompleto">Full Name</label>
            <input type="text" name="nombreCompleto" id="nombreCompleto" value="<?=$nombre?>" readonly /></div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?=$email?>" readonly></div>
        <div> 
            <label for="Password">Password</label>
            <input type="text" name="Password" id="Password"></div>
        <div>
            <label for="cPassword">Confirm Password</label>
            <input type="text" name="cPassword" id="cPassword"></div>
        <div>
            <label for="date">Date of Birth</label>
            <input type="text" name="date" id="date" value="<?=$date?>" readonly></div>
        <div><?pintaSelect($idiomas,"Lenguages");?></div>
        <div>
            <label for="descripcionPersonal"> Personal</label>
            <input type="textbox" name="descripcionPersonal" id="descripcionPersonal" value="<?=$descripcion?>" >
        </div>
            <input type="submit" name="save" id="save" value="S A V E">
        </form>
        <form action="" method="POST">
            <label for="">Profile picture</label>
            <br>
            <img src="<?=$imagen?>" alt="<?=$imagen?>">
            <br>
            <input TYPE="file" NAME="imagen" VALUE="<?= isset($imagen)?$imagen: "";?>">
        </form>
    </main>
    
<?include("../templates/pl_tie.html");?>

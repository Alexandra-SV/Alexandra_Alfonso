<?php
    $titulo="Modify your info";
    //Verifica cookie y usa css adecuado
    if(isset($_COOKIE['fondo']) && array_key_exists($_COOKIE['fondo'],$coloresCookie)){
        $css="../css/ModifUsuario".htmlspecialchars($_COOKIE['fondo']).".css";
    }else{
        $css="../css/ModifUsuarioPink.css";
    }
    include("../templates/pl_encabezado.php");
    include("../libs/bComponentes.php");
    //Comporbacion parte privada
    if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
?>
    <header>
        <div>
            <a href="../forms/form_mainpage.php"> &#60; To main page</a>
            <form action="" id="log">
                <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
            </form>
        </div>
        <h1>Services-Usuario</h1>
        <form action="">
            <label for="colorFondo"></label>
                <?=pintaDesplegable($coloresCookie,'colorFondo');?>
            <input type="submit" value="Change" name="bChange">
        </form>
    </header><!--Redirige a inicio -->
    <main>
        <form action="" method="POST" id="form-usuario" enctype="multipart/form-data">
            <section id="s1">
                <div>
                    <label for="nombreCompleto">Full Name*</label>
                        <span name="nombreCompleto" id="nombreCompleto"> <?=$userValues['nombre']?></span>
                </div>
                <div>
                    <label for="email">Email*</label>
                        <span name="email" id="email" ><?=$userValues['email']?></span>
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
                        <span name="date" id="date" ><?=$userValues['f_nacimiento']?></span>
                </div>
                <div><label for="languages">Languages</label><br>
                        <?=pintaSelect($userLenguages,"languages");?><!--No creo q vaya pero bueno 0~0  -->
                        <?php
                            echo (isset($errores['languages'])) ? "<span class=\"error\">".$errores['languages']."</span><br>" : "";
                        ?>
                </div>
                <div>
                    <label for="descripcionPersonal"> Personal description</label><br>
                        <textarea name="descripcionPersonal" id="descripcionPersonal"><?=$userValues['descripción']?></textarea>
                        <?php
                            echo (isset($errores['descripcionPersonal'])) ? "<span class=\"error\">".$errores['descripcionPersonal']."</span><br>" : "";
                        ?>
                </div>
                    <input type="submit" name="bSave" id="save" value="S A V E">
            </section>
            <section id="div-image">
                <span>Profile picture</span>
                    <br>
                <img src="<?=$userValues['foto_perfil']?>" alt="profPicture">
                    <br>
                <label for="boton">Select a file</label>
                    <input type="file" name="imagen" value="imagen-perfil" id="boton" >
                    <?php
                        echo (isset($errores['imagen'])) ? "<span class=\"error\">".$errores['imagen']."</span><br>" : "";
                    ?>
            </section>
        </form>
    </main>
    <footer> <!--ALFONSO, AQUI NO SE VE EL FOOTER, NO SE POR QUE-->
        <form action="" method="post" class="<?=$class?>">
            <label for="cookie">¿Aceptas la politica de cookies de nuestra página?</label>
                <?=pintaRadio(['si','no'],'cookie');?>
                <input type="submit" value="politica" name="bPolitic">
        </form>
    </footer>
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
<?php
    //Pie
    include("pl_pie.html");
?>
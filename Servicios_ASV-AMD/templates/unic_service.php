<?php
    $titulo="Unic Service";
    //Verifica cookie y usa css adecuado
    if(isset($_COOKIE['fondo']) && array_key_exists($_COOKIE['fondo'],$coloresCookie)){
        $css="../css/form_unic_service".htmlspecialchars($_COOKIE['fondo']).".css";
    }else{
        $css="../css/form_unic_servicePurple.css";
    }
    include("../templates/pl_encabezado.php");
    include("../libs/bComponentes.php");
    $tipo=($servicio['tipo']==0)?"Pago":"Intercambio";
?>
    <header>
        <div>
            <a href="../forms/form_mainpage.php"> &#60; To main page</a>
            <form action="" id="log">
                <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
            </form>
        </div>
        <h1>Service-Contact</h1>
        <form action="">
            <label for="colorFondo"></label>
            <?=pintaDesplegable($coloresCookie,'colorFondo');?>
            <input type="submit" value="Change" name="bChange">
        </form>
    </header><!--Redirige a inicio -->
    <main>
        <div class="info">
            <img src="<?=$servicio['foto_servicio']?>" alt="">
            <div class="text">
                <p><?=$servicio['titulo']?></p>
                <p><?=$tipo?></p>
                <p><?=$servicio['precio']?>€</p>
                <p id="description"><?=$servicio['descripcion']?></p>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for=" servicedescription">Message</label><br>
                <textarea name="servicedescription" id="servicedescription"></textarea>
                <?php
                    echo (isset($errores['servicedescription'])) ? "<span class=\"error\">".$errores['servicedescription']."</span><br>" : "";
                ?>
            </div>
                <input type="submit" name="bSave" id="bSave" value="S E N D">
        </form>
    </main>
    <footer >
        <form action="" method="post" class="<?=$class?>">
            <label for="cookie">¿Aceptas la politica de cookies de nuestra página?</label>
                <?=pintaRadio(['si','no'],'cookie');?>
                <input type="submit" value="politica" name="bPolitic">
        </form>
    </footer>
<?php
    //Pie
    include("pl_pie.html");
?>
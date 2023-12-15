<?php
    session_start();
    setTimer('timeout',300);
    include("../libs/bComponentes.php");
    //Encabezado
    $titulo = "Welcome to Services";
    //Verifica cookie y usa css adecuado
    if(isset($_COOKIE['fondo']) && array_key_exists($_COOKIE['fondo'],$coloresCookie)){
        $css="../css/mainpage".htmlspecialchars($_COOKIE['fondo']).".css";
    }else{
        $css="../css/mainpagePink.css";
    }
    include("../templates/pl_encabezado.php");
    //Comporbacion parte privada
    if($_SESSION['access'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
    //recoger usuario
     $user = $_SESSION['active'];
?>
  <form action="">
    <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
  </form>
  <header>
    <h1>Services</h1>
  </header>
  <nav>
    <div id="user">
      <span>Welcome, <?=$_SESSION['active']?></span>
      <?php
        echo "<a href=\"../forms/form_usuario.php\"><img height=\"50\"width=\"50\"src=\"".$_SESSION['imgPerfil']."\" alt=\"profPicture\"></a>";
      ?>
    </div>
    <form action="">
      <label for="colorFondo"></label>
      <?=pintaDesplegable($coloresCookie,'colorFondo');?>
      <input type="submit" value="Change" name="bChange">
    </form>
  </nav>
  <main>
    <div id="lista">
    <?=pintaServicio( $pdo, "servicios", "titulo",$errores)?>
    </div>
  </main>
  <a href="../forms/form_servicios.php" id="bAddService">+ add more services</a>
  <footer class="<?=$class?>">
      <form action="" method="post" class="<?=$class?>">
          <label for="cookie">¿Aceptas la politica de cookies de nuestra página?</label>
            <?=pintaRadio(['si','no'],'cookie');?>
          <input type="submit" value="politica" name="bPolitic">
      </form>
  </footer>
  </body>
</html>
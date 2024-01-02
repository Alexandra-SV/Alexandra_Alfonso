<?php
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
    //Configura usuarios no logueados a 0
    if(!isset($_SESSION['level']))
        $_SESSION['level'] = 0;
    //Comporbacion parte privada
    if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
    //recoger usuario
     $user = $_SESSION['user'];
     //conectamos con la bd
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    $usuario=selectRow( $pdo, "usuario", "email",$_SESSION['user'],$errores);
    $user_id=$usuario[0]['id_user'];
?>
  <form action="">
    <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
  </form>
  <header>
    <h1>Services</h1>
  </header>
  <nav>
    <div id="user">
      <span>Welcome, <?=$_SESSION['user']?></span>
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
    <?=pintaServicios($pdo,"servicios","id_user", $user_id, $errores)?>
  </main>
  <a href="../forms/form_servicios.php" id="bAddService">+ add more services</a>
  <footer class="<?=$class?>">
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
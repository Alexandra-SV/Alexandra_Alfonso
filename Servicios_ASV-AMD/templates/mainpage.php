<?php
    session_start();
    setTimer('timeout',300);
    include("../libs/bComponentes.php");
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/mainpage.css";
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
      <?=pintaServicio();?>
    </div>
  </main>
  <a href="../forms/form_servicios.php" id="bAddService">+ add more services</a>
<script>
    window.onload=function(){
      //Coge cookies
      var cookieString = document.cookie;
      //Divide las cookies y pone el color
      var cookies = cookieString.split("; ");
      for(let i = 0; i < cookies.length; i++) {
        if(cookies[i].indexOf('fondo') != -1) {
          document.body.style.background= cookies[i].substring(6);
        }
      }
    };
</script>

  <?php include("pl_pie.html"); ?>
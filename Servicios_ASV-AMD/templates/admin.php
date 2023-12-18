<?php
    //setTimer('timeout',300);
    include("../libs/bComponentes.php");
    //Encabezado
    $titulo = "Admin Page";
    $css="../css/admin.css";
    include("../templates/pl_encabezado.php");
    //Comporbacion parte privada
    /* if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    }; */
    //recoger usuario
    //$user = $_SESSION['user'];
?>
  <form action="">
    <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
  </form>
  <header>
    <h1>Admin Page</h1>
  </header>
  <nav>
    <div id="user">
      <!-- <span>Welcome, <?=$_SESSION['user']?></span>
      <?php
        echo "<a href=\"../forms/form_usuario.php\"><img height=\"50\"width=\"50\"src=\"".$_SESSION['imgPerfil']."\" alt=\"profPicture\"></a>";
      ?> -->
    </div>
  <main>

  </main>
  </body>
</html>
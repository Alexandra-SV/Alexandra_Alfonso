<?php
    session_start();
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/mainpage.css";
    include("../templates/pl_encabezado.php");
    include("../libs/bGeneral.php");
    include("../libs/bComponentes.php");
    //recoger usuario
    if(empty($_SESSION['active'])){
      header('location:../forms/formInicioSesion.php');
    }
    $user = $_SESSION['active'];
?>
  <form action="">
    <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
  </form>
  <header>
    <h1>Services</h1>
  </header>
  <nav>
    <span>Welcome, <?=$_SESSION['active']?></span>
    <?php
      echo "<a href=\"../forms/form_usuario.php\"><img height=\"50\"width=\"50\"src=\"".$_SESSION['imgPerfil']."\" alt=\"profPicture\"></a>";
    ?>
  </nav>
  <main>
    <div id="lista">
      <?=pintaServicio();?>
    </div>
  </main>
  <a href="../forms/form_servicios.php" id="bAddService">+ add more services</a>
<?php include("pl_pie.html"); ?>
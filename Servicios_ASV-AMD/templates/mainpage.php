<?php
    session_start();
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/mainpage.css";
    include("../templates/pl_encabezado.php");
    include("../libs/bGeneral.php");
    include("../libs/bComponentes.php");
    //recoger usuario
    $user = $_SESSION['active'];
    if($user == ""){
      header('location:../forms/formInicioSesion.php');
    }
?>
<form action="">
  <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
</form>
<header>
<h1>Services</h1>
</header>
<nav>
  <span>Welcome, <?=$_SESSION['usuarios'][$user]['fullName']?></span>
  <?php
      if($_SESSION['usuarios'][$user]['profilePicture'] != 1){
          echo "<a href=\"../forms/form_usuario.php\"><img height=\"50\"width=\"50\"src=\"".$_SESSION['usuarios'][$user]['profilePicture']."\" alt=\"profPicture\"></a>";
      }else{
          echo "<a href=\"../forms/form_usuario.php\"><img height=\"50\"width=\"50\"src=\"../img/imgPerfil/default_picture_donotdelete.jpg\" alt=\"profPicture\"></a>";
      }
  ?>
</nav>
<main>
     <?=pintaServicios($user);?><!--arreglar y cambiar a pintaServicios($user)-->
</main>
<a href="../forms/form_servicios.php" id="bAddService">+ add more services</a>
<?php
include("pl_pie.html");
?>
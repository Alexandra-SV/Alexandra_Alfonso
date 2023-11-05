<?php
    //$nombre=$_SESSION["usuarios"][$email]["fullName"];
    //$imagen=$_SESSION["usuarios"][$email]["profilePicture"];
    if(!isset($_SESSION)) session_start();
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/inicioSesion.css";
    include("../templates/pl_encabezado.php");
    include("../libs/bGeneral.php");
    include("../libs/bComponentes.php");
    //recoger usuario
    $user = recoge('user');
    if($user == ""){
      header('location:../forms/formInicioSesion.php');
    }
?>
<header>
<h1>Services</h1>
<span>Welcome, <?=$_SESSION['usuarios'][$user]['fullName']?></span>
<?php
    if($_SESSION['usuarios'][$user]['profilePicture'] != 1){
        echo "<a href=\"./form_usuario.php\"><img height=\"100\"width=\"100\"src=\"".$_SESSION['usuarios'][$user]['profilePicture']."\" alt=\"profPicture\"></a>";
    }else{
        echo "<a href=\"./form_usuario.php\"><img height=\"100\"width=\"100\"src=\"../img/imgPerfil/default_picture_donotdelete.jpg\" alt=\"profPicture\"></a>";
    }
?>
</header>
<main>
   <form action="" method="">
     <?=pintaServicios($user);?>
     <input type="submit" name="bAddService" value="+ add more services">
     <input type="submit" name="bLogOut" value="Log Out">
   </form>
</main>
<?
include("../templates/pl_pie.html");
?>
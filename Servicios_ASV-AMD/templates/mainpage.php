<?php
    session_start();
    include("../libs/bGeneral.php");
    setTimer('timeout',300);
    include("../libs/bComponentes.php");
    //Encabezado
    $titulo = "Welcome to Services";
    $css = "../css/mainpage.css";
    include("../templates/pl_encabezado.php");
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
    <label for="fondo"></label>
    <?=pintaSelect(['PaleVioletRed','MediumOrchid'],'fondo');?>
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
<script>
    window.onload=function(){
      document.getElementById('fondo').addEventListener('change',color,false);
    };
    function color(){
      var c=this[this.selectedIndex].value;
      document.body.style.background=c;
    }
</script>

  <?php include("pl_pie.html"); ?>
<?$titulo="MainPageForm";
$css="Servicios_ASV-AMD\css\ModifUsuario.css";
include("../templates/pl_encabezado.php");
$nombre=$_SESSION["Usuario"].["nombre"];
$imagen=$_SESSION["Usuario"].["imagen"];
?>
<header><h1>Services</h1><span>Wellcome, <?=$nombre?></span><a href="./form_usuario.php"><img src="<?=$imagen?>" alt="<?=$imagen?>"></a></header>
   <main>
        <?//pintaServicios();?>
        <input type="submit" value="bAddService" placeholder="+ ad more services">
   </main>
<?include("../templates/pl_tie.html");?>
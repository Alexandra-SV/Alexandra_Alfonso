<?php 
if(!isset($_SESSION)) session_start();
include("../templates/pl_encabezado.php");
include("../libs/bGeneral.php");

$languagesArray = ["Italian","Spanish","German","Chinese"];
$extensionesValidas=["jpeg","jpg","png","gif"];
$errores=[];
$error=false;

//variables a utilizar
$password;
$languages;
$description;
$newImage;
$dir="../img/imgPerfil/";
//recojo usario
/*$user = recoge('user');
if($user == ""){
  header('location:../forms/formInicioSesion.php');
}*/

    if (!isset($_REQUEST['bSave'])) {
        include ('../templates/usuario.php');//para en este punto 
    }
    else {   
    //Sanitizamos
        $password=recoge('Password');
        $languages=recoge('Lenguages');
        $description=recoge('descripcionPersonal',true);
        
    //Validamos
    cTexto( $pass,"Password",$errores,25,10);
    cCheck( $languages,"Lenguages",$errores,$languagesArray);
    cTexto( $description,"descripcionPersonal",$errores,100);
    $newImage=cFile('imagen',$errores,$extensionesValidas,$dir,2000000,false);
   
    //Comprobamos que no haya errores para cactualizar los datos
    if (empty($errores)){
        $_SESSION['usuarios'][$user]['languages']= $languages;
        $_SESSION['usuarios'][$user]['password']= $password;
        $_SESSION['usuarios'][$user]['description']= $description;
        $_SESSION['usuarios'][$user]['profilePicture']= $newImage;
        header("location:form_mainpage.php?user=$user");
    }else
        include("../templates/usuario.php");//va a la pag principal del usuario ?
    }
?>	  

<?include("../templates/pl_pie.html");?>
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
//imagen
$newImage;
$dir="../img/imgPerfil/";
$max_file_size = "2000000";

//recojo usario
$user = recoge('user');
if($user == ""){
  header('location:../forms/formInicioSesion.php');
}
$email=$_SESSION['usuarios'][$user]['email'];

    if (!isset($_REQUEST['bSave'])) {
        include ('../templates/usuario.php');
    }
    else {   
    //Sanitizamos
        $password=recoge('password');
        $languages=recogeArray('languages');
        $description=recoge('descripcionPersonal',true);
        
    //Validamos
    cTexto( $password,"password",$errores,25);
    cCheck( $languages,"languages",$errores,$languagesArray);
    cTexto( $description,"descripcionPersonal",$errores,100);
    $newImage=cFile('imagen',$errores,$extensionesValidas,$dir,2000000);
   
    //Comprobamos que no haya errores para cactualizar los datos
    if (empty($errores)){
        $_SESSION['usuarios'][$user]['languages']= $languages;
        $_SESSION['usuarios'][$user]['password']= $password;
        $_SESSION['usuarios'][$user]['description']= $description;
        $_SESSION['usuarios'][$user]['profilePicture']= $newImage;
        header("location:form_mainpage.php?user=$email");
    }else
        include("../templates/usuario.php");
    }
?>	  

<?include("../templates/pl_pie.html");?>
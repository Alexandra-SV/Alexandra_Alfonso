<?php
session_start();
include("../templates/pl_encabezado.php");
include("../libs/bGeneral.php");
include("../libs/bConfiguracion.php");
$errores=[];
$error=false;

//variables a utilizar
$password;
$languages;
$description;

//recojo usario
$user = $_SESSION['active'];
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
    cPassword( $password,"password",$errores,false);
    cCheck( $languages,"languages",$errores,$languagesArray,false);
    cTextarea( $description,"descripcionPersonal",$errores,100,0,false);

    //Comprobamos que no haya errores para cactualizar los datos
    if (empty($errores)) {
        $imagen=cFile('imagen',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
        if(empty($errores)){//cambiar luego para mostrar error directamente y no que introduzca la default
           $_SESSION['usuarios'][$user]['languages']= ($languages)? $languages : $_SESSION['usuarios'][$user]['languages'];
            $_SESSION['usuarios'][$user]['password']= ($password)? $password : $_SESSION['usuarios'][$user]['password'] ;
            $_SESSION['usuarios'][$user]['description']= ($description)? $description : $_SESSION['usuarios'][$user]['description'] ;
            $_SESSION['usuarios'][$user]['profilePicture']= ($imagen)? $imagen : $_SESSION['usuarios'][$user]['profilePicture'];
            header("location:form_mainpage.php");
        }else{
            //$imagen="../img/imgPerfil/default_picture_donotdelete.jpg";
            include("../templates/usuario.php");
        }
    }else
        include("../templates/usuario.php");
    }
?>

<?include("../templates/pl_pie.html");?>
<?php
session_start();
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
//Imagen
$dir = "../img/imgPerfil/";
$max_file_size = "2000000";
$extensionesValidas = array(
    "jpeg",
    "jpg",
    "png",
    "gif",
);

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
    cPassword( $password,"password",$errores);
    cCheck( $languages,"languages",$errores,$languagesArray);
    cTextarea( $description,"descripcionPersonal",$errores,100,1,false);

    //Comprobamos que no haya errores para cactualizar los datos
    if (empty($errores)) {
        $imagen=cFile('imagen',$errores,$extensionesValidas,$dir,$max_file_size,false);
        if($imagen != 1){
            echo "<img src=\"".$imagen."\" alt=\"profPicture\"></a>";
        }else{
            echo "<img src=\"../img/imgPerfil/default_picture_donotdelete.jpg\" alt=\"profPicture\"></a>";
            $imagen="../img/imgPerfil/default_picture_donotdelete.jpg";
        }



        $_SESSION['usuarios'][$user]['languages']= $languages;
        $_SESSION['usuarios'][$user]['password']= $password;
        $_SESSION['usuarios'][$user]['description']= $description;
        $_SESSION['usuarios'][$user]['profilePicture']= $imagen;
        header("location:form_mainpage.php?user=$email");

    }else
        include("../templates/usuario.php");
    }
?>

<?include("../templates/pl_pie.html");?>
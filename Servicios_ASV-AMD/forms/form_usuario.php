<?php
session_start();
include("../libs/bGeneral.php");
include("../libs/bConfiguracion.php");
$errores=[];
$error=false;
//TODO: NO MODIFICAR DATOS USUARIO, SOLO MOSTRAR
//variables a utilizar
$password;
$languages;
$description;

//recojo usario
$user = $_SESSION['active'];
if($user == ""){
  header('location:../forms/formInicioSesion.php');
}

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

    //Comprobamos que no haya errores para actualizar los datos mas adelante con BBDD
    if (empty($errores)) {
        $imagen=cFile('imagen',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
        if($imagen==1)
            $imagen="../img/imgPerfil/default_picture_donotdelete.jpg" ;
        if(empty($errores)){
             header("location:form_mainpage.php");
        }else
            include("../templates/usuario.php");
    }else
        include("../templates/usuario.php");
    }
?>

<?include("../templates/pl_pie.html");?>
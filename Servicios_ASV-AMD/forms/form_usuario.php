<?php
session_start();
include("../libs/bGeneral.php");
setTimer('timeout',300);
include("../libs/bConfiguracion.php");
$errores=[];
$error=false;

//variables a utilizar
$password;
$languages;
$description;

//Comporbacion parte privada
if($_SESSION['access'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
    header("location:formInicioSesion.php");
};

    //Cambia la cookie
    $color = "";
    $errores = [];
    if(isset($_REQUEST['bChange'])){
        $color = recoge('colorFondo');
        cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
        if(empty($errores)){
            setcookie('fondo',$coloresCookie[$color]);
            header('location:form_usuario.php');
        }
    }

//comprueba si la cookie de politica existe y si su valor es valido
//si no existe muestra el form para poder aceptar o negar las cookies
if(isset($_COOKIE['politica'])){
    $cookie=htmlspecialchars($_COOKIE['politica']);
    ($cookie != 'si' || $cookie != 'no')?$class="hide":$class="show";
}else
    $class="";
//crea la cookie al clicar el submit de las cookies
if(isset($_REQUEST['bPolitic'])){
    $respCookie = recoge('cookie');
    cRadio($respCookie,'politicaCookie',$errores,['si','no'],false);
    if(empty($errores)){
        setcookie('politica',$respCookie,time()+1000);
        header('location:form_usuario.php');
    }
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

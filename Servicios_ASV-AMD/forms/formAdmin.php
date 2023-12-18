<?php
session_start();
include("../libs/bGeneral.php");
//setTimer('timeout',300);
include("../libs/bConfiguracion.php");

$errores=[];

//variables a utilizar

//Cambia la cookie
$color = "";
if(isset($_REQUEST['bChange'])){
    $color = recoge('colorFondo');
    cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
    if(empty($errores)){
        setcookie('fondo',$coloresCookie[$color]);
        header('location:formAdmin.php');
    }
}
//comprueba si la cookie de politica existe y si su valor es valido
//si no existe muestra el form para poder aceptar o negar las cookies
if(isset($_COOKIE['politica'])){
    $cookie=htmlspecialchars($_COOKIE['politica']);
    ($cookie != 'si' || $cookie != 'no')?$class="hide":$class="";
}else
    $class="";
//crea la cookie al clicar el submit de las cookies
if(isset($_REQUEST['bPolitic'])){
    $respCookie = recoge('cookie');
    cRadio($respCookie,'politicaCookie',$errores,['si','no'],false);
    if(empty($errores)){
        setcookie('politica',$respCookie,time()+1000);
        header('location:formAdmin.php');
    }
}

//Comporbacion parte privada
/* if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
    header("location:formInicioSesion.php");
}; */
/* $user = $_SESSION['user']; */
    if (!isset($_REQUEST['bSave'])){
        include ('../templates/admin.php');
    }
    else {

    }
?>

<?include("../templates/pl_pie.html");?>
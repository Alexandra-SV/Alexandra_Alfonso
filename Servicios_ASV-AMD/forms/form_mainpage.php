<?php
    session_start();
    include('../modelo/consultas.php');
    include("../libs/bGeneral.php");
    include("../libs/bConfiguracion.php");
//Manejo de cookies
    //Cambia la cookie de fondo
        $color = "";
        $errores = [];
        if(isset($_REQUEST['bChange'])){
            $color = recoge('colorFondo');
            cRadios($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
            if(empty($errores)){
                setcookie('fondo',$coloresCookie[$color]);
                header('location:form_mainpage.php');
            }
        }
    //comprueba si la cookie de politica existe y si su valor es valido
    //si no existe muestra el form para poder aceptar o negar las cookies
        if(isset($_COOKIE['politica'])){
            $cookie=htmlspecialchars($_COOKIE['politica']);
            ($cookie == 'si')?$class="hide":$class="";
        }else
            $class="";
    //crea la cookie al clicar el submit de las cookies
        if(isset($_REQUEST['bPolitic'])){
            $respCookie = recoge('cookie');
            cRadios($respCookie,'politicaCookie',$errores,['si','no'],false);
            if(empty($errores)){
                setcookie('politica',$respCookie,time()+1000);
                header('location:form_mainpage.php');
            }
        }
//Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
    if(!isset($_REQUEST['bLogOut'])){//Si no se ha pulsado volvemos al formulario
        include("../templates/mainpage.php");
    }
?>
<?php
    include("../libs/bGeneral.php");
    include("../libs/bConfiguracion.php");
    //Cambia la cookie
    $color = "";
    $errores = [];
    if(isset($_REQUEST['bChange'])){
        $color = recoge('colorFondo');
        cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
        if(empty($errores)){
        setcookie('fondo',$coloresCookie[$color]);
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
        }
    }

    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }else{//Si no se ha pulsado volvemos al formulario
        include("../templates/mainpage.php");
    }
?>
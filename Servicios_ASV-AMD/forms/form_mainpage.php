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
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }else{//Si no se ha pulsado volvemos al formulario
        include("../templates/mainpage.php");
    }
?>
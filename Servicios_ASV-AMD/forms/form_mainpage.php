<?php
    //Compruebo si se ha pulsado el botón de servicios
    if (!isset($_REQUEST['bAddService'])) {//Si se ha pulsado redirigimos al formulario deseado
        include("../templates/mainpage.php");
    }else{
        include ('form_addService.php');//formulario de servicios
    }
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {//Sino se ha pulsado volvemos al formulario
        session_start();
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
?>
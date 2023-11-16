<?php
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {//Si no se ha pulsado volvemos al formulario
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }else{
        include("../templates/mainpage.php");
    }
?>
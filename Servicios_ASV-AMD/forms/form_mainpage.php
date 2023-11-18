<?php
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }else{//Si no se ha pulsado volvemos al formulario
        include("../templates/mainpage.php");
    }
?>
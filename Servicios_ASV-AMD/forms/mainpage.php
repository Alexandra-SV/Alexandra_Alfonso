<?php
include("../templates/pl_encabezado.php");

//Compruebo si se ha pulsado el botón del formulario
if (!isset($_REQUEST['bAddService'])) {//Sino se ha pulsado volvemos al formulario
    include ('./form_mainpage.php');
} // Si se ha pulsado redirigimos al formulario deseado
else {
    include ('./form_mainpage.php');//formulario de servicios
}
?>
		  

<?php

pie();
?>
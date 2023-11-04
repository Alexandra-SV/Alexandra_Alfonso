<?php
    //Librerias
    include('../../libs/bGeneral.php');
    //Datos y array de errores
    $errores = [];
    $email = "";
    $password = "";
    if(!isset($_REQUEST['bSignIn'])){
        include("../../templates/inicioSesion.php");
    }else{
        //Sanitizar

        //Validar

        //Pasar a correcto
        if(empty($errores)){
            header('location:formLoggedIn.php');
        }
    }
?>
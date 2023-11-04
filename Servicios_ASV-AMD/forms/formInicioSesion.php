<?php
    //Iniciar session
    if(!isset($_SESSION)) session_start();
    //Librerias
    include('../libs/bGeneral.php');
    //Datos y array de errores
    $errores = [];
    $email = "";
    $password = "";
    if(!isset($_REQUEST['bEnter'])){
        include("../templates/inicioSesion.php");
    }else{ //Clic a iniciar sesion
        //Sanitizar
        $email = recoge('email');
        $password = recoge('password');
        //Ver que existe el user
        cUser($email,$password,'usuario',$errores);
        //Pasar a correcto
        if(empty($errores)){
            header("location:form_mainpage.php?user=$email");
        }else{
            include("../templates/inicioSesion.php");
        }
    }
?>
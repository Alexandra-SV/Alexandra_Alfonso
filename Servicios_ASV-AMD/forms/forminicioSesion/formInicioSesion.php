<?php
    //Librerias
    include('../../libs/bGeneral.php');
    //Datos y array de errores
    $errores = [];
    $email = "";
    $password = "";
    //Iniciar session
    session_start();
    if(!isset($_REQUEST['bEnter'])){
        include("../../templates/inicioSesion.php");
    }else{
        //Sanitizar
        $email = recoge('email');
        $password = recoge('password');
        //Validar con la session
        if(in_array($email,$_SESSION['usuarios'])){

        }

        //Pasar a correcto
        if(empty($errores)){
            header('location:formPrincipal.php');
        }
    }
?>
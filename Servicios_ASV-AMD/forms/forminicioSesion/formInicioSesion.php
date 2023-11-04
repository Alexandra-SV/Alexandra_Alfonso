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
    }else{ //Clic a iniciar sesion
        //Sanitizar
        $email = recoge('email');
        $password = recoge('password');
        //Validar con la session
        if(isset($_SESSION['usuarios'][$email])){
            echo "olee";
        }
        //Pasar a correcto
        if(empty($errores)){
            //header('location:form_mainpage.php');
        }
    }
?>
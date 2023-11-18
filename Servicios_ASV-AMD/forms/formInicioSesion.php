<?php
    //Iniciar session
    session_start();
    //Librerias
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
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
        cUser($email, $password,'usuario',$errores);
        //Pasar a correcto
        if(empty($errores)){
            //guardar en variable de sesion al user
            $_SESSION['active'] = $email;
            header("location:form_mainpage.php");
        }else{
            file_put_contents("../ficheros/logLogin.txt", "".$email."|".$password ."|".date("d-m-Y,h:i:s",time()).PHP_EOL,FILE_APPEND);
            include("../templates/inicioSesion.php");
        }
    }
?>
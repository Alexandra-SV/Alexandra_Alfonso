<?php
    //Iniciar session
    session_start();
    //Librerias
    include('../modelo/consultas.php');
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    include('../libs/bConfiguracion.php');
    //Iniciar conexion
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    //Datos y array de errores
    $errores = [];
    $email = "";
    $password = "";
    if(!isset($_REQUEST['bEnter'])){
        if(!isset($_SESSION['access']))
            $_SESSION['access'] = 0;
        include("../templates/inicioSesion.php");
    }else{ //Clic a iniciar sesion
        //Sanitizar
        $email = recoge('email');
        $password = recoge('password');
        //Ver que existe el user
        cUser($email, $password,'login',$errores,$pdo);
        //Pasar a correcto
        if(empty($errores)){
            $_SESSION['user'] = $email;
            $_SESSION['imgPerfil'] = getRowValue('usuario', 'email', $email, 'foto_perfil', $errores, $pdo);
            $_SESSION['timeout']=time();
            $_SESSION['level'] = 1;
            $_SESSION['ip']= $_SERVER["REMOTE_ADDR"];
            //TODO: coger el active segun el user de la bd
                //if($userActive == 1) //Solo login admitido de usuarios activos
                    header("location:form_mainpage.php");
                /* else
                    $errores['login'] = 'Activa tu cuenta para iniciar sesión'; */
        }else{
            file_put_contents("../ficheros/logLogin.txt", "".$email."|".$password ."|".date("d-m-Y,h:i:s",time()).PHP_EOL,FILE_APPEND);
            include("../templates/inicioSesion.php");
        }
    }
    //Cerrar conexion
    stopBd($pdo, $errores);
?>
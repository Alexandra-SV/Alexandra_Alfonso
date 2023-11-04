<?php
    //Librerias
    include('../../libs/bGeneral.php');
    //Datos y array de errores
    $errores = [];
    $fullName = "";
    $email = "";
    $password = "";
    $dateOfBirth = "";
    $languages = "";
    $description = "";

    //Imagen
    $dir = "../../img/imgPerfil/";
    $max_file_size = "2000000";
    $extensionesValidas = array(
        "jpeg",
        "jpg",
        "png",
        "gif",
    );
    //Iniciar session
    session_start();
    //Ver que existe el array de usuarios, si no se crea
    if(!isset($_SESSION['usuarios'])){
        $_SESSION['usuarios'] = array();
    }

    if(!isset($_REQUEST['bRegister'])){
        include("../../templates/registro.php");
    }else{ //Clic a iniciar sesion
        //Sanitizar
        $fullName = recoge('fullName');
        $email = recoge('email');
        $password = recoge('password');
        $dateOfBirth = recoge('dateOfBirth');
        $languages = recogeArray('languages');
        $description = recoge('description');
        //Validar
        cTexto($fullName,'fullName',$errores);
        cEmail($email,'email',$errores);
        cDate($dateOfBirth,'dateOfBirth',$errores);
        cTexto($description,'description',$errores);
        //Pasar a correcto
        if(empty($errores)){
            //Imagen
            $profilePicture = cFile('profilePicture',$errores,$extensionesValidas,$dir,$max_file_size,false);
            //Guarda el usuario en session con la id del email, si no hay errores
            $usuario = array(
                "email"=>$email,
                "password"=>$password,
                "fullName"=>$fullName,
                "dateOfBirth"=>$dateOfBirth,
                "profilePicture"=>$profilePicture,
                "languages"=>$languages,
                "description"=>$description,
            );
            $_SESSION['usuarios'][$email] = $usuario;
            //header('location:form_mainpage.php?&imagen=$imagen');
        }
    }
?>
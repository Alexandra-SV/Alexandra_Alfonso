<?php
    //Iniciar session
    if(!isset($_SESSION)) session_start();
    //Librerias
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    //Datos y array de errores
    $errores = [];
    $fullName = "";
    $email = "";
    $password = "";
    $dateOfBirth = "";
    $languages = "";
    $description = "";

    $languagesArray = ["Italian","Spanish","German","Chinese"];
    //Imagen
    $dir = "../img/imgPerfil/";
    $max_file_size = "2000000";
    $extensionesValidas = array(
        "jpeg",
        "jpg",
        "png",
        "gif",
    );
    //Ver que existe el array de usuarios, si no se crea
    if(!isset($_SESSION['usuarios'])){
        $_SESSION['usuarios'] = array();
    }
    if(!isset($_REQUEST['bRegister'])){
        include("../templates/registro.php");
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
        cPassword($password,'password',$errores,true);
        cDate($dateOfBirth,'dateOfBirth',$errores);
        cCheck($languages,'languages',$errores, $languagesArray, false);
        cTexto($description,'description',$errores, 30, 1, TRUE, TRUE, false);
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
                "services"=>[
                ]
            );
            $_SESSION['usuarios'][$email] = $usuario;
            header("location:form_mainpage.php?user=$email");
        }else{
            include("../templates/registro.php");
        }
    }
?>
<?php
    //Iniciar session
    session_start();
    //Librerias
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    include("../libs/bConfiguracion.php");
    //Datos y array de errores
    $errores = [];
    $fullName = "";
    $email = "";
    $password = "";
    $dateOfBirth = "";
    $languages = "";
    $description = "";

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
            $profilePicture = cFile('profilePicture',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
            //Guarda el usuario en session con la id del email, si no hay errores hacr if para la foto
            if($profilePicture == 1){
                $profilePicture = "../img/imgPerfil/default_picture_donotdelete.jpg";
            }
            $usuario = array(
                "email"=>$email,
                "password"=>$password,
                "fullName"=>$fullName,
                "dateOfBirth"=>$dateOfBirth,
                "profilePicture"=>$profilePicture,
                "languages"=>$languages,
                "description"=>$description,
                "services"=>[]
            );
            file_put_contents("../ficheros/usuarios.txt", "".$usuario["email"]."|".$usuario["password"]."|".$usuario["fullName"]."|".$usuario["dateOfBirth"]."|".$usuario["profilePicture"]."|".implode(",",$usuario["languages"])."|".$usuario["description"]."|".date("d-m-Y h:i:s",time()).";".PHP_EOL,FILE_APPEND);
            //$_SESSION['usuarios'][$email] = $usuario;
            //Creo la sesion activa
            $_SESSION['active'] = $email;
            $_SESSION['imgPerfil'] = $profilePicture;
            header("location:formInicioSesion.php");
        }else{
            include("../templates/registro.php");
        }
    }
?>
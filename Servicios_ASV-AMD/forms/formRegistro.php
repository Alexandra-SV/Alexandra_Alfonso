<?php
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
        cTextarea($description,'description',$errores, 30, 1, false);

        if(empty($errores)){
            //Imagen
            $profilePicture = cFile('profilePicture',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
            //Pasar a correcto
            if(empty($errores)){
                $usuario = array(
                    "email"=>$email,
                    "password"=>encriptar($password), //encripta la password
                    "fullName"=>$fullName,
                    "dateOfBirth"=>$dateOfBirth,
                    "profilePicture"=>($profilePicture == 1)?"../img/imgPerfil/default_picture_donotdelete.jpg":$profilePicture,
                    "languages"=>(empty($languages))?"none":implode(",",$languages),
                    "description"=>($description=="")?"none":$description,
                );
                //file_put_contents("../ficheros/usuarios.txt", "".$usuario["email"]."|".$usuario["password"]."|".$usuario["fullName"]."|".$usuario["dateOfBirth"]."|".$usuario["profilePicture"]."|".$usuario["languages"]."|".$usuario["description"]."|".date("d-m-Y,h:i:s",time()).PHP_EOL,FILE_APPEND);
                //TODO: meter datos en bd
                //generar token: bin2hex(random_bytes(64))
                header("location:formInicioSesion.php");
            }else{
                include("../templates/registro.php");
            }
        }else{
            include("../templates/registro.php");
        }
    }
?>
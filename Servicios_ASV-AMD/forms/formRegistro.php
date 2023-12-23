<?php
    //Librerias
    include('../modelo/consultas.php');
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    include("../libs/bConfiguracion.php");
    //Iniciar conexion
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
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
        cCheck($languages,'languages',$errores, $pdo, 'idioma', 'id_idioma', false);
        cTextarea($description,'description',$errores, 30, 1, false);

        if(empty($errores)){
            //1. generar token: bin2hex(random_bytes(64))
            $token = uniqid();
            //2. Guardar user en la bd con cuenta no activa
            //Imagen
            $profilePicture = cFile('profilePicture',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
            //Pasar a correcto
            if(empty($errores)){
                $usuario = array(
                    "nombre"=>$fullName,
                    "email"=>$email,
                    "pass"=>encriptar($password), //encripta la password
                    "f_nacimiento"=>$dateOfBirth,
                    "foto_perfil"=>($profilePicture == 1)?"../img/imgPerfil/default_picture_donotdelete.jpg":$profilePicture,
                    "descripción"=>($description=="")?"none":$description,
                    "nivel"=> 0,
                    "activo"=>0
                );
                insertRow($pdo, "usuario", $usuario,$errores);
                $idUser=$pdo->lastInsertId();
                foreach ($languages as $idioma) {
                   $idiomas=["id_user"=>$idUser,"id_idioma"=>$idioma];
                    insertRow($pdo, "idioma",$idiomas ,$errores);
                }
                //PARTE DEL COMPOSER
                    /* //3. Guardar token, id_user y validez en bd
                    //TODO: poner a 86400 segundos cuando se vea que va bien
                    insertRow($pdo, "tokens", [$token, time()+60, $idUser],$errores);
                    //PHPMailer
                    include '../PHPMailer/PHPMailer.php'; */
                //file_put_contents("../ficheros/usuarios.txt", "".$usuario["email"]."|".$usuario["password"]."|".$usuario["fullName"]."|".$usuario["dateOfBirth"]."|".$usuario["profilePicture"]."|".$usuario["languages"]."|".$usuario["description"]."|".date("d-m-Y,h:i:s",time()).PHP_EOL,FILE_APPEND);
                header("location:formInicioSesion.php");
            }else{
                include("../templates/registro.php");
            }
        }else{
            include("../templates/registro.php");
        }
    }
    //Cerrar conexion
    stopBd($pdo, $errores);
?>
<?php
    //Librerias
    include('../modelo/consultas.php');
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    include("../libs/bConfiguracion.php");
    try {
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
        //Lenguajes disponibles
        $languagesArray=selectColumn($pdo, "idioma", "idioma");
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
                //1. generar token
                $token = uniqid();
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
                        "nivel"=> 1,
                        "activo"=>0
                    );
                    //2. Guardar user en la bd con cuenta no activa
                    if(insertRow($pdo, "usuario", $usuario)){
                        $idUser=$pdo->lastInsertId();
                        if(!empty($languages)){
                            foreach ($languages as $idioma) {
                                $idiomas=["id_user"=>$idUser,"id_idioma"=>$idioma];
                                insertRow($pdo, "user_idioma",$idiomas);
                            }
                        }
                        //3. Guardar token, id_user y validez en bd
                        insertRow($pdo, "tokens", ['token'=>$token, 'validez'=>time()+86400, 'id_user'=>$idUser]);
                        //PHPMailer
                        include '../PHPMailer/PHPMailer.php';
                        header("location:formInicioSesion.php");
                    }else
                        $errores['insert'] = 'Error al registrar el usuario';//informa al user de que ha habido un problema al registrarse
                }else{
                    include("../templates/registro.php");
                }
            }else{
                include("../templates/registro.php");
            }
        }
        //Cerrar conexion
        stopBd($pdo);
    } catch (PDOEXCEPTION $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
?>
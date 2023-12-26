<?php
    session_start();
    include("../libs/bGeneral.php");
    $timeOut= setTimer('timeout',300);
    include("../libs/bConfiguracion.php");
    include("../modelo/consultas.php");
     
//variables a utilizar
    $password;
    $languages;
    $description;
    $errores=[];
//Comporbacion parte privada
    if($timeOut || $_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
    $user = $_SESSION['user'];
//Iniciar conexion
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
//Devuelve la row del user que coincida con el email que le pasamos
    $userValues=selectRow($pdo,'usuario','email',$user,$errores);
    $userValues=$userValues[0];
//recojo los lenguajes de la db
    $languagesArray=selectColumn($pdo, "idioma", "idioma", $errores);

    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
    //Manejo del formulario
    if (!isset($_REQUEST['bSave'])) {
        include ('../templates/usuario.php');
    }else {
        //Sanitizamos
            $password=recoge('password');
            $languages=recogeArray('languages');
            $description=recoge('descripcionPersonal',true);
        //Validamos
            cPassword( $password,"password",$errores,false);
            cCheck( $languages,"languages",$errores,$pdo, "idioma", "id_idioma",false);
            cTextarea( $description,"descripcionPersonal",$errores,100,0,false);
        //Comprobamos que no haya errores para actualizar los datos mas adelante con BBDD
            if (empty($errores)) {
                $imagen=cFile('imagen',$errores,$extensionesValidas,$dirPerfil,$max_file_size,false);
                if(empty($errores)){
                    $none="";
                    ($password!="")?$arr[]=['pass'=>encriptar($password)]:$none=true;
                    ($imagen!=1)?$arr[]=['foto_perfil'=>$imagen]:$none=true;
                    ($description!="" && $description!=$userValues['descripción'])?$arr[]=['descripción'=>$description]:$none=true;
                    if(!$none){
                        $arr=array_merge(...$arr);//... desempaqueta los elementos del array.
                        updateRow($pdo,'usuario',$arr,'id_user',$userValues['id_user'],$errores);   
                    }
                    if ($languages!="") {//habría que borrar todos los idiomasdel user y volverlos a añadir ??
                        $userLanguages= selectRow($pdo,'user_idioma','id_user',  $userValues['id_user'], $errores);
                        $userLanguages=array_merge_recursive(...$userLanguages);
                        $newLanguages=[];
                        foreach ($languages as $key => $idioma) {
                            (in_array($idioma,$userLanguages['id_idioma']))?$none=true:$newLanguages[]=["id_user"=>$userValues['id_user'],"id_idioma"=>$idioma];
                        }
                        foreach ($newLanguages as $key => $idioma) {
                            $idiomas=["id_user"=>$newLanguages[$key]["id_user"],"id_idioma"=>$newLanguages[$key]["id_idioma"]];
                            insertRow( $pdo, "user_idioma",$idiomas,$errores);
                        }
                    }
                    header("location:form_mainpage.php");
                }else
                    include("../templates/usuario.php");
            }else
                include("../templates/usuario.php");
    }
    //Apartado de Cookies
        //Cambia la cookie
        $color = "";
        if(isset($_REQUEST['bChange'])){
            $color = recoge('colorFondo');
            cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
            if(empty($errores)){
                setcookie('fondo',$coloresCookie[$color]);
                header('location:form_usuario.php');
            }
        }
        //comprueba si la cookie de politica existe y si su valor es valido
        //si no existe muestra el form para poder aceptar o negar las cookies
        if(isset($_COOKIE['politica'])){
            $cookie=htmlspecialchars($_COOKIE['politica']);
            ($cookie != 'si' || $cookie != 'no')?$class="hide":$class="show";
        }else
            $class="";
        //crea la cookie al clicar el submit de las cookies
        if(isset($_REQUEST['bPolitic'])){
            $respCookie = recoge('cookie');
            cRadio($respCookie,'politicaCookie',$errores,['si','no'],false);
            if(empty($errores)){
                setcookie('politica',$respCookie,time()+1000);
                header('location:form_usuario.php');
            }
        }
        //Cerrar conexion
        stopBd($pdo, $errores);
?>

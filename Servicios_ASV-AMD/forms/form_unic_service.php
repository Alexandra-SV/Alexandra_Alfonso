<?php
    session_start();
    include("../libs/bGeneral.php");
    setTimer('timeout',300);
    include("../libs/bConfiguracion.php");
    include("../modelo/consultas.php");
    $errores=[];
    //conectamos con la bd
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    //variables a utilizar 
    $descripcion;
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
    //Cambia la cookie
    $color = "";
    if(isset($_REQUEST['bChange'])){
        $color = recoge('colorFondo');
        cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
        if(empty($errores)){
            setcookie('fondo',$coloresCookie[$color]);
            header('location:form_servicios.php');
        }
    }
    //comprueba si la cookie de politica existe y si su valor es valido
    //si no existe muestra el form para poder aceptar o negar las cookies
    if(isset($_COOKIE['politica'])){
        $cookie=htmlspecialchars($_COOKIE['politica']);
        ($cookie != 'si' || $cookie != 'no')?$class="hide":$class="";
    }else
        $class="";
    //crea la cookie al clicar el submit de las cookies
    if(isset($_REQUEST['bPolitic'])){
        $respCookie = recoge('cookie');
        cRadio($respCookie,'politicaCookie',$errores,['si','no'],false);
        if(empty($errores)){
            setcookie('politica',$respCookie,time()+1000);
            header('location:form_servicios.php');
        }
    }
    //Comporbacion parte privada
    if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
    $user = $_SESSION['user'];
    if (!isset($_REQUEST['bSave'])){
        include ('../templates/servicios.php');
    }
    else {
        //sanitizamos
        $descripcion= recoge('servicedescription',true);
        //Validamos
        cTextarea( $descripcion,"servicedescription",$errores,100,0);
        //Comprobamos que no haya errores para crear el servicio
        if (empty($errores)) {
            


            header("location:form_mainpage.php");
        }else
            include("../templates/servicios.php");
    }
    //Cerrar conexion
    stopBd($pdo, $errores);
?>
<?php
    session_start();
    include("../libs/bGeneral.php");
    setTimer('timeout',300);
    include("../libs/bConfiguracion.php");
    include("../modelo/consultas.php");
    $errores=[];
    //conectamos con la bd
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    $Availability=selectColumn( $pdo,"disponibilidad","disponibilidad",  $errores);
    //variables a utilizar
    $titulo;
    $categoria;
    $tipo;
    $ubicacion;
    $disponibilidad;
    $precio;
    $descripcion;
    $imagen;
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
        $titulo=recoge('titulo',true);
        $tipo=recoge('tipo');
        $ubicacion=recoge('ubicacion',true);
        $disponibilidad=recogeArray('Availability');
        $precio=recoge('precioH');
        $descripcion= recoge('servicedescription',true);
        //Validamos
        cTexto( $titulo,"titulo",$errores,50,3);
        cRadio( $tipo,"tipo",$errores,$type);
        cTexto( $ubicacion,"ubicacion",$errores,50);
        cCheck( $disponibilidad,"disponibilidad",$errores,$Availability);
        cNum( $precio,"precioH",$errores);
        cTextarea( $descripcion,"servicedescription",$errores,100,0,false);
        if($descripcion=="")$descripcion="-";
        //Comprobamos que no haya errores para crear el servicio
        if (empty($errores)) {
            $imagen=cFile('servicePicture',$errores,$extensionesValidas,$dirServicio,$max_file_size,false);
            if(empty($errores)){
                if($imagen==1)
                    $imagen="../img/imgServ/servdefaultdonotdelete.jpg" ;
                header("location:form_mainpage.php");
            }else
                include("../templates/servicios.php");
        }else
            include("../templates/servicios.php");
        }
        //Cerrar conexion
        stopBd($pdo, $errores);
?>
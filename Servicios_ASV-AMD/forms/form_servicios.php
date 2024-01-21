<?php
    session_start();
    include("../libs/bGeneral.php");
    include("../libs/bConfiguracion.php");
    include("../modelo/consultas.php");
//variables a utilizar
    $titulo;
    $categoria;
    $tipo;
    $ubicacion;
    $disponibilidad;
    $precio;
    $descripcion;
    $imagen;
    $errores=[];
//Manejo de Cookies
    //Cambia la cookie de fondo
    $color = "";
    if(isset($_REQUEST['bChange'])){
        $color = recoge('colorFondo');
        cRadios($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
        if(empty($errores)){
            setcookie('fondo',$coloresCookie[$color]);
            header('location:form_servicios.php');
        }
    }
    //comprueba si la cookie de politica existe y si su valor es valido
    //si no existe muestra el form para poder aceptar o negar las cookies
    if(isset($_COOKIE['politica'])){
        $cookie=htmlspecialchars($_COOKIE['politica']);
        ($cookie == 'si')?$class="hide":$class="";
    }else
        $class="";
    //crea la cookie al clicar el submit de las cookies
    if(isset($_REQUEST['bPolitic'])){
        $respCookie = recoge('cookie');
        cRadios($respCookie,'politicaCookie',$errores,['si','no'],false);
        if(empty($errores)){
            setcookie('politica',$respCookie,time()+1000);
            header('location:form_servicios.php');
        }
    }
//Comporbacion parte privada
    if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || setTimer('timeout',300)){
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
        exit;
    };
    $user = $_SESSION['user'];
    try {
    //conectamos con la bd
        $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
        $Availability=selectColumn( $pdo,"disponibilidad","disponibilidad");
    //Devuelve la row del user que coincida con el email que le pasamos
        $userValues=selectRow($pdo,'usuario','email',$user);
        $userValues=$userValues[0];

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
                cRadios( $tipo,"tipo",$errores,$type);
                cTexto( $ubicacion,"ubicacion",$errores,50);
                cCheck( $disponibilidad,"disponibilidad",$errores, $pdo,"disponibilidad","id_disponibilidad");
                cNum( $precio,"precioH",$errores);
                cTextarea( $descripcion,"servicedescription",$errores,100,0);
            //Comprobamos que no haya errores para crear el servicio
                if (empty($errores)) {
                    $imagen=cFile('servicePicture',$errores,$extensionesValidas,$dirServicio,$max_file_size,false);
                    if(empty($errores)){
                        if($imagen==1)
                            $imagen="../img/imgServ/servdefaultdonotdelete.jpg" ;
                            $servicio = array(
                                "titulo"=>$titulo,
                                "id_user"=>$userValues['id_user'],
                                "descripcion"=>$descripcion,
                                "precio"=>$precio,
                                "tipo"=>$tipo,
                                "foto_servicio"=>$imagen,
                                "fecha_alta"=> date('Y-m-d', time()),
                            );
                        if(insertRow($pdo, "servicios", $servicio)){
                            $id_servicio=$pdo->lastInsertId();
                            foreach ($disponibilidad as $disponible) {
                                $arr=["id_servicio"=>$id_servicio,"id_disponibilidad"=>$disponible];
                                insertRow($pdo, "disp_servicio",$arr);
                            }
                        }else
                            $errores['insert'] = 'Error al registrar el usuario';//informa al user de que ha habido un problema al registrarse
                        header("location:form_mainpage.php");
                    }else
                        include("../templates/servicios.php");
                }else
                    include("../templates/servicios.php");
        }
        //Cerrar conexion
            stopBd($pdo);
    } catch (PDOEXCEPTION $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
//Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
?>
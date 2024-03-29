<?php
    session_start();
    include("../libs/bGeneral.php");
    include("../libs/bConfiguracion.php");
    include("../modelo/consultas.php");
//Manejo de Cookies
  //Cambia la cookie de fondo
      $color = "";
      if(isset($_REQUEST['bChange'])){
          $color = recoge('colorFondo');
          cRadios($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
          if(empty($errores)){
              setcookie('fondo',$coloresCookie[$color]);
              header('location:form_unic_service.php');
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
          header('location:form_unic_service.php');
      }
  }
//Comporbacion parte privada
      if($_SESSION['level'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || setTimer('timeout',300)){
          session_unset ();
          session_destroy();
          header("location:formInicioSesion.php");
          exit;
      };
    try {
    //conectamos con la bd
        $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    //variables a utilizar
        $descripcion;
        $errores=[];
        $user = $_SESSION['user'];
        $titulo = (isset($_GET['titulo']))?htmlspecialchars($_GET['titulo']):htmlspecialchars($_SESSION['titulo']);
        ($titulo!="")?$_SESSION['titulo']=$titulo:"";
        $servicio= selectRow($pdo,'servicios','titulo', $titulo);
            $servicio=$servicio[0];
    //Manejo de formulario
        if (!isset($_REQUEST['bSave'])){
            include ('../templates/unic_service.php');
        }else {
            //sanitizamos
                $descripcion= recoge('servicedescription',true);
            //Validamos
                cTextarea( $descripcion,"servicedescription",$errores,200,0);
            //Comprobamos que no haya errores para crear el servicio
                if (empty($errores)) {
                    $serviceUser=selectRow($pdo,'usuario','id_user', $servicio['id_user']);
                        $serviceUser=$serviceUser[0];
                    include '../PHPMailer/PHPMailer_service.php';
                    if(empty($errores))
                        header("location:form_mainpage.php");
                    else header("location:form_unic_service.php");
                }else
                    include("../templates/unic_service.php");
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
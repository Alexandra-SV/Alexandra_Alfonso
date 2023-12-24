<?php
    session_start();
    include("../libs/bGeneral.php");
    setTimer('timeout',300);
    include("../libs/bConfiguracion.php");
    include('../modelo/consultas.php');
    //Iniciar conexion
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    //Array de errores
    $errores=[];
    //variables a utilizar
    $valor = '';
    //Comporbacion parte privada
    if($_SESSION['level'] != 2 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
        header("location:formInicioSesion.php");
    };
    if (!isset($_REQUEST['bEnviarIdioma']) && !isset($_REQUEST['bEnviarDisponibilidad']) ){
        include ('../templates/admin.php');
    }
    else {
        if(!empty($_REQUEST['insertaIdioma'])){
            $valor = recoge('insertaIdioma');
            cTexto($valor,'insertaIdioma',$errores, 30, 1, FALSE, TRUE, FALSE);
            if(empty($errores)){
                insertRow($pdo, 'idioma', ['idioma'=>$valor], $errores);
                header('location:formAdmin.php');
            }
        }
        else if(!empty($_REQUEST['insertaDisponibilidad'])){
            $valor = recoge('insertaDisponibilidad');
            cTexto($valor,'insertaDisponibilidad',$errores, 30, 1, FALSE, TRUE, FALSE);
            if(empty($errores)){
                insertRow($pdo, 'disponibilidad', ['disponibilidad'=>$valor], $errores);
                header('location:formAdmin.php');
            }
        }
        else if(isset($_REQUEST['idioma'])){
            $valor = recoge('idioma');
            cRadio($valor, 'idioma',$errores, $pdo, 'idioma', 'id_idioma', false);
            if(empty($errores)){
                deleteRow($pdo, 'idioma', 'id_idioma', $valor, $errores);
                header('location:formAdmin.php');
            }
        }
        else if(isset($_REQUEST['disponibilidad'])){
            $valor = recoge('disponibilidad');
            cRadio($valor, 'disponibilidad',$errores, $pdo, 'disponibilidad', 'id_disponibilidad', false);
            if(empty($errores)){
                deleteRow($pdo, 'disponibilidad', 'id_disponibilidad', $valor, $errores);
                header('location:formAdmin.php');
            }
        }else{
            header('location:formAdmin.php');
        }
    }
    //Compruebo si se ha pulsado el botón de cerrar sesion
    if (isset($_REQUEST['bLogOut'])) {
        session_unset ();
        session_destroy();
        header("location:formInicioSesion.php");
    }
?>

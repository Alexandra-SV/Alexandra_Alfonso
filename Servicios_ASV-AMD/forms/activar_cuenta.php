<?php
    include('../modelo/consultas.php');
    include('../libs/bGeneral.php');
    include('../libs/bComponentes.php');
    include('../libs/bConfiguracion.php');
    //Iniciar conexion
    $pdo = conectBd($db_hostname,$db_nombre,$db_usuario,$db_clave);
    //Datos y array de errores
    $errores = [];
    //Coger token
    $token = $_GET['token'];
    //Buscar en la tabla para ver si existe y siguie siendo válido
    $fila = selectRow($pdo, 'tokens', 'token', $token, $errores);
    if($fila){
        $validez = 3600;
        $tiempo = time() - $fila[0]['validez'];
        if($tiempo < $validez){
            //Activar la cuenta
            $idUser = $fila[0]['id_user'];
            if(updateRow($pdo,'usuario',['activo'=>1], 'id_user', $idUser, $errores))
                echo('Cuenta activada');
            //Eliminar de la tabla
            deleteRow($pdo, 'tokens', 'token', $token, $errores);
        }else{ //Se pasa de validez
            //Eliminar por pasarse del tiempo
            deleteRow($pdo, 'tokens', 'token', $token, $errores);
            echo 'ERROR';
        }
    }else{ //No está el token
        echo 'ERROR';
    }
?>
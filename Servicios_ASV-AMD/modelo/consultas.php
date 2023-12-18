<?php

/**
 * function conectBd
 *
 * Conecta con la BBDD.
 * si es exitosa devuelve el objeto de la conexión si no false
 *
 * @param string $db_hostname
 * @param string $db_nombre
 * @param string $db_usuario
 * @param string $db_clave
 *
 * @return object|bool
 */
function conectBd(string $db_hostname,string $db_nombre,string $db_usuario,string $db_clave):object|bool{
    try{
        $pdo = new PDO('mysql:host=' . $db_hostname . ';dbname=' . $db_nombre . '', $db_usuario, $db_clave);
        // Realiza el enlace con la BD en utf-8
        $pdo->exec("set names utf8");
        //Accionamos el uso de excepciones
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e) {
        $errores[]="Error al conectar la BBDD: ";
        // En este caso guardamos los errores en un archivo de errores log
        error_log($e->getMessage().microtime().PHP_EOL,3,"../log/logBd.txt");
    }
    if($pdo) return $pdo;
    else return false;
}

/**
 * function stopBd
 *
 * Si existe la BBDD se cierra o,
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param array $errores
 *
 * @return bool
 */
function stopBd(object $pdo,array &$errores):bool{
    try{
        if($pdo){
            $pdo=null;
            return true;
        }
    }catch (PDOException $e) {
        $errores[]="Error al cerrar la BBDD: ";
        // En este caso guardamos los errores en un archivo de errores log
        error_log($e->getMessage().microtime().PHP_EOL,3,"../log/logBd.txt");
        //guardamos en ·errores el error que queremos mostrar a los usuarios
        $pdo =false;
    }
        return false;
}
/* Consultas no parametrizadas*/

/**
 * function getAllTable
 *
 * Devuelve toda una tabla en manera de array o,
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param string $tabla
 * @param array $errores
 *
 * @return array|bool
 */
function getAllTable(object $pdo,string $tabla,array &$errores):array|bool{
    $consulta = "SELECT * FROM $tabla";
    if($res= $pdo->query($consulta)){
        $resArray = $res->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }else{
        $errores[]="Error al seleccionar la tabla: ".$tabla;
       return false;
    }
}

/* Consultas parametrizadas*/

/**
 * Funcion selectCol
 *
 * Devuelve la columna concreta. Reporta error en un error.log.
 *
 * @param object $pdo
 * @param string $tabla
 * @param string $columna
 * @param array $errores
 * @return array|bool
 */
function selectCol(object $pdo, string $tabla, string $columna, array $errores): array|bool{
    $consulta = "SELECT $columna FROM $tabla ";
    if($res= $pdo->query($consulta)){
        $resArray = $res->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }
    $errores[]="Error al seleccionar la tabla: ".$tabla;
    return false;
}

/**
 * Funcion selectRow
 *
 * Devuelve la fila concreta. Reporta error en un error.log.
 *
 * @param object $pdo
 * @param string $tabla
 * @param string $columna
 * @param string $valor
 * @param array $errores
 * @return array|bool
 */
function selectRow(object $pdo, string $tabla, string $columna, string $valor, array &$errores): array|bool{
    $consulta = "SELECT * FROM $tabla WHERE $columna = ?";
    $resultado = $pdo->prepare($consulta);
    $resultado->bindParam(1,$valor);
    if($resultado->execute()){
        $resArray = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }
    $errores[]="Error al seleccionar la tabla: ".$tabla;
    return false;
}
/**
 * function addRowAnonim
 *
 * Si existe la BBDD añade una fila a la tabla de manera anónima,
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param string $tabla
 * @param array $valores
 * @param array $errores
 *
 * @return bool
 */
function insertRowAnonim(object $pdo,string $tabla,array $valores,array &$errores):bool{
    if($pdo){
        $stValueColumns="";
        $llaves=array_keys($valores);
        $stColumns=implode(",",$llaves);
        $arr=[];
        for ($i=0; $i <count($llaves) ; $i++) {
             $arr[$i]=':'.$llaves[$i];
        }
        $stValueColumns=implode(",",$arr);
        try{
           $consulta=$pdo->prepare("INSERT INTO $tabla ($stColumns) values($stValueColumns)");
            if($consulta->execute($valores)) return true; //si se ejecuta el insert devuelve true
            else return false;
        }catch(PDOException $e){
            $errores[]="error al conectar con la BBDD";
            error_log($e->getMessage().microtime().PHP_EOL,3,"../log/logBd.txt");
            //guardamos en ·errores el error que queremos mostrar a los usuarios
        }
    }else {
        $errores[]="error al conectar con la BBDD";
        return false;
    }
}
/**
 * function addInfoColumn
 *
 * Si existe la BBDD añade los valores a la tabla de manera anónima,
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param string $tabla
 * @param array $valores
 * @param array $errores
 *
 * @return bool
 */
function addInfoColumn(object $pdo,string $tabla,string $nomCol,array $valores,array &$errores):bool{
    if($pdo){
        try{
            $consulta=$pdo->prepare("INSERT INTO $tabla ($nomCol) values(?)");
            for ($i=0; $i < count($valores); $i++) {
                $consulta->bindParam(1,$valores[$i]);
                if(!$consulta->execute($valores))return false; //si se ejecuta el insert devuelve true
            }
            return true;
        }catch(PDOException $e){
            $errores[]=$e->getMessage();
            return false;
        }
    }else {
        $errores[]="error al conectar con la BBDD";
        return false;
    }
}
?>

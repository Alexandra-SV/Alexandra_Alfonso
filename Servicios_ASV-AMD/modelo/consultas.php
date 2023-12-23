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
//TODO: VER COMO USAR
/**
 * function normalArray
 *
 * Convierte un array bidimensional a uno unidimensional para su uso conveniente
 *
 * @param array $arrayBidimensional
 *
 * @return array
 */
function normalArray(array $arrayBidimensional, $campo): array{
    foreach($arrayBidimensional as $key=>$id_columna){
        //Cada key es el número de columna y la id_columna son los pares clave:valor
        foreach($id_columna as $key=>$value){
            //Para guardar el value de cada par, o sea el campo de la tabla
            $array[]=$value;
        }
    }
    return $array;
}
/* Consultas no parametrizadas*/

/**
 * function selectTable
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
function selectTable(object $pdo,string $tabla,array &$errores):array|bool{
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
 * Funcion selectColumn
 *
 * Devuelve la columna concreta. Reporta error en un error.log.
 *
 * @param object $pdo
 * @param string $tabla
 * @param string $columna
 * @param array $errores
 * @return array|bool
 */
function selectColumn(object $pdo, string $tabla, string $columna, array $errores): array|bool{
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
 * function insertRow
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
function insertRow(object $pdo,string $tabla,array $valores,array &$errores):bool{
    //Forma anon
    if($pdo){
        $stValueColumns="";
        $llaves=array_keys($valores);
        $stColumns=implode(",",$llaves); //Nombres de cada columna separados por ,
        $arr=[];
        for ($i=0; $i <count($llaves) ; $i++) {
             $arr[]='?'; //Valores a dar de forma ?
        }
        $stValueColumns=implode(",",$arr);
        try{
           $consulta=$pdo->prepare("INSERT INTO $tabla ($stColumns) values($stValueColumns)");
           $i = 1;
           foreach ($valores as $key => $value) {
                $consulta->bindParam($i,$value);
                $i++;
           }
            if($consulta->execute()) return true; //si se ejecuta el insert devuelve true
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
    /* if($pdo){
        $stValueColumns="";
        $llaves=array_keys($valores);
        $stColumns=implode(",",$llaves); //Nombres de cada columna separados por ,
        $arr=[];
        for ($i=0; $i <count($llaves) ; $i++) {
             $arr[$i]=':'.$llaves[$i]; //Valores a dar de forma :nombre
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
    } */
}
//TODO: ESTE METODO ME PARECE IGUAL QUE INSERTROW MENOS POR ALGUNAS COSITAS, SI AL FINAL DEL TRABAJO NO LO USAMOS BORRAR
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
/**
 * function updateRow
 *
 * Actualiza los datos de una fila y una tabla concretas
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param string $tabla
 * @param array $valores
 * @param string $colId
 * @param string $id
 * @param array $errores
 *
 * @return bool
 */
function updateRow(object $pdo,string $tabla,array $valores,string $colId,string $id,array &$errores):bool{
    if ($pdo) {
        try {
            $strActualizar = "";
            foreach ($valores as $key => $value) {
                $strActualizar .= "$key=:$key, ";
            }
            $strActualizar = rtrim($strActualizar, ', ');
            $consulta = $pdo->prepare("UPDATE $tabla SET $strActualizar WHERE $colId = :id");
            // Vincular valores con marcadores de posición
            foreach ($valores as $key => $value) {
                $consulta->bindValue(":$key", $value);
            }
            $consulta->bindValue(":id", $id);
            if (!$consulta->execute())return false; // Si ocurre un error en la ejecución, devuelve false
            return true; // Si se ejecuta correctamente, devuelve true
        } catch (PDOException $e) {
            $errores[] = $e->getMessage();
            return false;
        }
    } else {
        $errores[] = "Error al conectar con la BBDD";
        return false;
    }
}

/**
 * function deleteRow
 *
 * Elimina una fila de la tabla,
 * en caso de algun error, devuelve false y añade
 * el error a un array de errores recursivo
 *
 * @param object $pdo
 * @param string $tabla
 * @param array $valores
 * @param string $colId
 * @param string $id
 * @param array $errores
 *
 * @return bool
 */
function deleteRow(object $pdo, string $tabla, string $columna, string $valor, array &$errores): bool{
    $consulta = "DELETE FROM $tabla WHERE $columna=?";
    try {
        $resultado = $pdo->prepare($consulta);
        $resultado->bindParam(1,$valor);
        // Comprobamos cuantas filas se han borrado
        $cuenta = $resultado->rowCount();
        if ($cuenta)
            return true;
    } catch (PDOException $e) {
        error_log($e->getMessage().microtime().PHP_EOL,3,"../log/logBd.txt");
        $errores[] = $e->getMessage();
    }
    return false;
}
?>

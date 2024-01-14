<?php
/****
 * Librería con funciones de consultas SQL
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */

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
    $pdo = new PDO('mysql:host=' . $db_hostname . ';dbname=' . $db_nombre . '', $db_usuario, $db_clave);
    // Realiza el enlace con la BD en utf-8
    $pdo->exec("set names utf8");
    //Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
 *
 * @return bool
 */
function stopBd(object $pdo):bool{
    if($pdo){
        $pdo=null;
        return true;
    }
    return false;
}
/**
 * function normalArray
 *
 * Convierte un array bidimensional a uno unidimensional para su uso conveniente
 *
 * @param array $arrayBidimensional
 *
 * @return array
 */
function normalArray(array $arrayBidimensional): array{
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
 *
 * @return array|bool
 */
function selectTable(object $pdo,string $tabla):array|bool{
    $consulta = "SELECT * FROM $tabla";
    if($res= $pdo->query($consulta)){
        $resArray = $res->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }else{
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
 * @return array|bool
 */
function selectColumn(object $pdo, string $tabla, string $columna): array|bool{
    $consulta = "SELECT $columna FROM $tabla ";
    if($res= $pdo->query($consulta)){
        $resArray = $res->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }
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
 * @return array|bool
 */
function selectRow(object $pdo, string $tabla, string $columna, string $valor, string $igual="="): array|bool{
    $consulta = "SELECT * FROM $tabla WHERE $columna $igual ?";
    $resultado = $pdo->prepare($consulta);
    $resultado->bindParam(1,$valor);
    if($resultado->execute()){
        $resArray = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $resArray;
    }
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
 *
 * @return bool
 */
function insertRow(object $pdo,string $tabla,array $valores):bool{
  if($pdo){
    $stValueColumns="";
    $llaves=array_keys($valores);
    $stColumns=implode(",",$llaves); //Nombres de cada columna separados por ,
    $arr=[];
    for ($i=0; $i <count($llaves) ; $i++) {
            $arr[]='?'; //Valores a dar de forma ?
    }
    $stValueColumns=implode(",",$arr);
        $consulta=$pdo->prepare("INSERT INTO $tabla ($stColumns) values($stValueColumns)");
        $i = 1;
        foreach ($valores as $key => $value) {
            $consulta->bindValue($i,$value);
            $i++;
        }
        if($consulta->execute()) return true; //si se ejecuta el insert devuelve true
        else return false;
    }else {
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
 *
 * @return bool
 */
function updateRow(object $pdo,string $tabla,array $valores,string $colId,string $id):bool{
    if ($pdo) {
        $strActualizar = "";
        foreach ($valores as $key => $value) {
            $strActualizar .= "$key=?, ";
        }
        $strActualizar = rtrim($strActualizar, ', ');
        $consulta = $pdo->prepare("UPDATE $tabla SET $strActualizar WHERE $colId = ?");
        // Vincular valores con marcadores de posición
        $i=1;
        foreach ($valores as $key => $value) {
            $consulta->bindValue($i, $value);
            $i++;
        }
        $consulta->bindValue(count($valores)+1, $id);
        if (!$consulta->execute())return false; // Si ocurre un error en la ejecución, devuelve false
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
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
 *
 * @return bool
 */
function deleteRow(object $pdo, string $tabla, string $columna, string $valor): bool{
    $consulta = "DELETE FROM $tabla WHERE $columna=?";
    $resultado = $pdo->prepare($consulta);
    $resultado->bindParam(1,$valor);
    // Comprobamos cuantas filas se han borrado
    if ($resultado->execute()){
        $cuenta = $resultado->rowCount();
        if ($cuenta)
            return true;
    }
    return false;
}
?>

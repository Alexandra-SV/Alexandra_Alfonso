<?php
include ('../libs/bConfiguracion.php');
try {
    $pdo = new PDO('mysql:host='.$db_hostname, $db_usuario, $db_clave);
    //UTF8
    $pdo->exec("set names utf8");
    // Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Leemos el fichero que contiene el sql
    $sqlBD = file_get_contents("evaluable_7W.sql");
    //Ejecutamos la consulta
    $pdo->exec($sqlBD);
    echo ("La BD ha sido creada");
    //Cerramos conexion
    $pdo = null;
} catch (PDOException $e) {
    // En este caso guardamos los errores en un archivo de errores log
    error_log($e->getMessage() . "## Fichero: " . $e->getFile() . "## Línea: " . $e->getLine() . "##Código: " . $e->getCode() . "##Instante: " . microtime() . PHP_EOL, 3, "../log/logBD.txt");
    // guardamos en ·errores el error que queremos mostrar a los usuarios
    $errores['datos'] = "Ha habido un error <br>";
}
?>
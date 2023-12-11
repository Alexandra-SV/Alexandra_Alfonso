<?php
    include('../libs/bConfiguracion.php');
    // Conectamos
    $pdo = new PDO('mysql:host=' . $db_hostname . ';dbname=' . $db_nombre . '', $db_usuario, $db_clave);
    // Realiza el enlace con la BD en utf-8
    $pdo->exec("set names utf8");
    //Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
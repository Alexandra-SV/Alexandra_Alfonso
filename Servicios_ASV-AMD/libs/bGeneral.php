<?php
/****
 * Librería con funciones generales, de sanitización y de validación
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */
//***** Funciones de sanitización **** //

/**
 * funcion sinTildes
 *
 * Elimina caracteres con tilde de las cadenas
 *
 * @param string $frase
 * @return string
 */
function sinTildes($frase): string
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}

/**
 * Funcion sinEspacios
 *
 * Elimina los espacios de una cadena de texto
 *
 * @param string $frase
 * @return string
 */
function sinEspacios($frase)
{
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}

/**
 * Funcion recoge
 *
 * Sanitiza cadenas de texto
 *
 * @param string $var
 * @param bool $espacios
 * @return string
 */
function recoge(string $var,$espacios=false)
{
    if (isset($_REQUEST[$var]) && (!is_array($_REQUEST[$var]))) {
        if ($espacios)
            $tmp = $_REQUEST[$var];
        else
            $tmp = sinEspacios($_REQUEST[$var]);

        $tmp = strip_tags($tmp);
    } else
        $tmp = "";

    return $tmp;
}

/**
 * Funcion recogeArray
 *
 * Sanitiza arrays
 *
 * @param string $var
 * @return array
 */
function recogeArray(string $var): array
{
    $array = [];
    if (isset($_REQUEST[$var]) && (is_array($_REQUEST[$var]))) {
        foreach ($_REQUEST[$var] as $valor)
            $array[] = strip_tags(sinEspacios($valor));
    }

    return $array;
}

//***** Funciones de validación **** //

/**
 * Funcion cTexto
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 *
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $max
 * @param integer $min
 * @param bool $espacios
 * @param bool $case
 * @param bool $required
 * @return bool
 */
function cTexto(string $text, string $campo, array &$errores, int $max = 30, int $min = 1, bool $espacios = TRUE, bool $case = TRUE, bool $required=true): bool
{
    if(!$required && $text == ""){
        return true;
    }else{
        $case = ($case === TRUE) ? "i" : "";
        $espacios = ($espacios === TRUE) ? " " : "";
        if ((preg_match("/^[a-zñ$espacios]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
            return true;
        }
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cTextarea
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 *
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $max
 * @param integer $min
 * @param bool $case
 * @return bool
 */
function cTextarea(string $text, string $campo, array &$errores, int $max = 30, int $min = 1, bool $required=true): bool
{
    if(!$required && $text == ""){
        return true;
    }else{
        if ((preg_match("/[a-zñ1-9 ]{" . $min . "," . $max . "}$/ui", $text))) {
            return true;
        }
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cEmail
 *
 * Valida una cadena de texto con respecto a una RegEx para email. Reporta error en un array.
 *
 * @param string $email
 * @param string $campo
 * @param array $errores
 * @return bool
 */
function cEmail(string $email, string $campo, array &$errores): bool{
    /* if(preg_match("/^[a-z][\w._]{2,}@([a-z]+[a-z\.]+\.[a-z]{2,})$/i",$email))
        return true; */
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;

    $errores[$campo] = "Error en el campo $campo";
    return false;
}
/**
 * Funcion cDate
 *
 * Valida una fecha. Reporta error en un array.
 *
 * @param string $fecha
 * @param string $campo
 * @param array $errores
 * @return string
 */
function cDate(String $fecha, string $campo, array &$errores): string{
    if($fecha != ""){
        $fechaArray = explode("-",$fecha);
        if(checkdate($fechaArray[1],$fechaArray[2],$fechaArray[0])){
            if($fechaArray[0] > 1950 && $fechaArray[0] < 2005)
            return true;
        }
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }else{
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
}
/**
 * Funcion cNum
 *
 * Valida que un string sea numerico menor o igual que un número y si es o no requerido. Reporta error en un array.
 *
 * @param string $num
 * @param string $campo
 * @param array $errores
 * @param bool $requerido
 * @param integer $max
 * @return bool
 */
function cNum(string $num, string $campo, array &$errores, bool $requerido = TRUE, int $max = PHP_INT_MAX): bool
{
    $cuantificador = ($requerido) ? "+" : "*";
    if ((preg_match("/^[0-9]" . $cuantificador . "$/", $num))) {
        if ($num <= $max) return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cRadio
 *
 * Valida que un string se encuentre entre los valores posibles. Si es requerido o no. Reporta error en un array.
 *
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * @return bool
 */
function cRadio(string $text, string $campo, array &$errores, object $pdo, string $tabla, string $columna, bool $requerido = TRUE): bool{
    if (($requerido) && $text == "") {
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    if (!selectRow($pdo,$tabla,$columna,$text,$errores)) {
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    return true;
}

/**
 * Funcion cCheck
 *
 * Valida que los valores seleccionados en un checkbox array están dentro de los valores válidos dados en un array. Si es requerido o no. Reporta error en un array.
 *
 * @param array $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * @return bool
 */
function cCheck(array $text, string $campo, array &$errores, object $pdo, string $tabla, string $columna, bool $requerido = TRUE): bool{
    if (($requerido) && (count($text) == 0)) {
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    foreach ($text as $valor) {
        if (!selectRow($pdo,$tabla,$columna,$valor,$errores)) {
            $errores[$campo] = "Error en el campo $campo";
            return false;
        }
    }
    return true;
}

/**
 * Funcion cUser
 *
 * Valida que el usuario exista dentro de la base de datos. Reporta error en un array.
 *
 * @param string $email
 * @param string $password
 * @param string $campo
 * @param array $errores
 * @param object $pdo
 * @return bool
 */
function cUser(string $email, string $password, string $campo, array &$errores, object $pdo): bool{
    $tabla = 'usuario';
    $columna = 'email';
    try {
        $resultado = selectRow($pdo, $tabla, $columna, $email, $errores);
        if(!empty($resultado)){ //Email esta bien porque el select ha sido exitoso
            //Comprobar password
            $bdPass = $resultado[0]['pass'];
            //Encriptar contraseñas de usuarios no registrados desde la web porque no están encriptadas
            if($bdPass == 'alex' || $bdPass == 'alf'|| $bdPass == 'admin')
                $bdPass = encriptar($bdPass);
            if(password_verify($password, $bdPass))
                return true;
        }
    } catch (PDOEXCEPTION $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cPassword
 *
 * Valida la existencia del campo contraseña. Reporta error en un array.
 *
 * @param string $pass
 * @param string $campo
 * @param array $errores
 * @param bool $required
 * @return bool
 */
function cPassword(string $pass, string $campo, array &$errores, bool $required=true): bool{
    if($required && $pass == ""){
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }else{
        return true;
    }
}

/**
 * Funcion cFile
 *
 * Valida la subida de un archivo a un servidor. Reporta error en un array.
 *
 * @param string $nombre
 * @param array $errores
 * @param array $extensiones_validas
 * @param string $directorio
 * @param integer $max_file_size
 * @param boolean $required
 * @return bool|string
 */
function cFile(string $nombre, array &$errores, array $extensionesValidas, string $directorio, int  $max_file_size,  bool $required = TRUE): bool|string
{
    // Caso especial que el campo de file no es requerido y no se intenta subir ningun archivo
    if ((!$required) && $_FILES[$nombre]['error'] === 4)
        return true;
    // En cualquier otro caso se comprueban los errores del servidor
    if ($_FILES[$nombre]['error'] != 0) {
        $errores["$nombre"] = "Error al subir el archivo " . $nombre . ". Prueba de nuevo";
        return false;
    } else {
        $nombreArchivo = strip_tags($_FILES["$nombre"]['name']);//= ""
        /*
             * Guardamos nombre del fichero en el servidor
        */
        $directorioTemp = $_FILES["$nombre"]['tmp_name'];//= null
        /*
             * Calculamos el tamaño del fichero
            */
        $tamanyoFile = filesize($directorioTemp);//= false
        /*
            * Extraemos la extensión del fichero, desde el último punto.
        */
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));//=""
        /*
            * Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
        */
        if (!in_array($extension, $extensionesValidas)) {
            $errores["$nombre"] = "La extensión del archivo no es válida";
            return false;
        }
        /*
            * Comprobamos el tamaño del archivo
        */
        if ($tamanyoFile > $max_file_size) {
            $errores["$nombre"] = "La imagen debe de tener un tamaño inferior a $max_file_size kb";
            return false;
        }
        // Almacenamos el archivo en ubicación definitiva si no hay errores ( al compartir array de errores TODOS LOS ARCHIVOS tienen que poder procesarse para que sea exitoso. Si cualquiera da error, NINGUNO  se procesa)
        if (empty($errores)) {
            /*
                * Comprobamos si el directorio pasado es válido
            */
            if (is_dir($directorio)) {
                /*
                    * Tenemos que buscar un nombre único para guardar el fichero de manera definitiva.
                    * Podemos hacerlo de diferentes maneras, en este caso se hace añadiendo microtime() al nombre del fichero
                    * si ya existe un archivo guardado con ese nombre.
                **/
                $nombreArchivo = is_file($directorio . DIRECTORY_SEPARATOR . $nombreArchivo) ? time() . $nombreArchivo : $nombreArchivo;
                $nombreCompleto = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;
                /*
                    * Movemos el fichero a la ubicación definitiva.
                 * */
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                    /*
                        * Si todo es correcto devuelve la ruta y nombre del fichero como se ha guardado
                     */
                    return $nombreCompleto;
                } else {
                    $errores["$nombre"] = "Ha habido un error al subir el fichero";
                    return false;
                }
            }else {
                $errores["$nombre"] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
}

//****** Funcionces set ****/
/**
 * Funcion setTimer
 *
 * Crea un timeout de inactividad del usuario. Reporta error en un array.
 *
 * @param string $timerName
 * @param int $time
 * @return bool
 */
 function setTimer(string $timerName,int $time):bool{
    $inact=$time;
    $lifetime=time()-$_SESSION[$timerName];
    if($lifetime>$inact){
        echo"sesion cerrada por inactividad";
        session_start();
        session_unset();
        session_destroy();
        return true;
    }else $_SESSION[$timerName]=time();
    return false;
}

//****** Funciones encriptar ****/
/**
 * Funcion encriptar
 *
 * Encripta una contraseña y devuelve el hash de esta o false en caso de error.
 *
 * @param string $password
 * @param int $cost=10
 * @return int|bool
 */

function encriptar($password, $cost=10):string|bool{
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
}
?>
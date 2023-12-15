<?php
/****
 * Librería con funciones de generación de componentes
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */

//***** Funciones get **** //
//TODO: hacer estas funciones con bd
/**
 * Funcion getUser
 *
 * Devuelve datos del usuario indicado.
 *
 * @param string $email
 * @return array|bool
 */
/* function getUser(string $email): array|bool{
    $datos = file_get_contents("../ficheros/usuarios.txt");
    $datosArray = explode(PHP_EOL,$datos);
    for ($i=0; $i < $datosArray; $i++) {
        $usuario = explode("|",$datosArray[$i]);
        if($usuario[0] == $email)
            return $usuario;
    }
    return false;
} */
//TODO: hacer estas funciones con bd
/**
 * Funcion getUserValue
 *
 * Devuelve dato concreto del usuario indicado según la posición del dato en el fichero.
 *
 * @param string $email
 * @param int $pos
 * @return array|bool
 */
/* function getUserValue(string $email, int $pos): string|bool{
    $datos = file_get_contents("../ficheros/usuarios.txt");
    $datosArray = explode(PHP_EOL,$datos);
    for ($i=0; $i < $datosArray; $i++) {
        $usuario = explode("|",$datosArray[$i]);
        if($usuario[0] == $email)
            return $usuario[$pos];
    }
    return false;
} */

/**
 * Funcion getRowValue
 *
 * Devuelve dato concreto de la fila.
 *
 * @param string $email
 * @param int $pos
 * @return array|bool
 */
function getRowValue(string $tabla, string $columna, string $valor, string $campo, array &$errores, object $pdo): string|bool{
    try {
        $resultado = selectRow($pdo, $tabla, $columna, $valor, $errores);
        if($resultado !== false){ //Usuario encontrado
            return $resultado[0][$campo];
        }
    } catch (PDOEXCEPTION $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
    $errores = "Error al buscar el dato";
    return false;
}

/**
 * Funcion getTituloServicios
 *
 * Devuelve los titulos de los servicios.
 *
 * @return array
 */
function getTituloServicios(): array{
    $file = fopen("../ficheros/servicios.txt", "r");
    $titulos=[];
        while (!feof($file)){
            $linea = fgets($file);
            if ($linea!="") {
                $service=explode("|",$linea);
                $titulos[]=$service[0];
            }
        }
        fclose($file);
    return $titulos;
}

//***** Funciones de creación de elementos **** //

/**
 * Funcion pintaRadio
 *
 * Pinta un radio en un formulario.
 *
 * @param array $valores
 * @param string $campo
 */
function pintaRadio(array $valores, string $campo){
    for ($i=0; $i < count($valores); $i++) {
        echo "<input type=\"radio\" name=\"$campo\" VALUE=\"$valores[$i]\"> $valores[$i] ";
    }
}

/**
 * Funcion pintaCheck
 *
 * Pinta un checkbox en un formulario.
 *
 * @param array $valores
 * @param string $campo
 */
function pintaCheck(array $valores, string $campo){
    for ($i=0; $i < count($valores); $i++) {
        echo "<input type=\"checkbox\" name=\"".$campo."[]\" VALUE=\"$valores[$i]\"> $valores[$i] <br>";
    }
}

/**
 * Funcion pintaSelect
 *
 * Pinta un select múltiple en un formulario.
 *
 * @param array $valores
 * @param string $name
 */
function pintaSelect(array $valores,string $name){
    echo "<select name=\"".$name."[]\"id=\"$name\" multiple>";
    for ($i=0; $i < count($valores); $i++) {
        echo "<option value=\"$valores[$i]\" >". $valores[$i] ."</option>";
    }
    echo "</select>";
}
/**
 * Funcion pintaDesplegable
 *
 * Pinta un select en un formulario.
 *
 * @param array $valores
 * @param string $name
 */
function pintaDesplegable(array $valores,string $name){
    echo "<select name=\"".$name."\"id=\"$name\">";
    echo "<option value=\"\" disabled selected hidden>Page color</option>";
    foreach ($valores as $key => $value) {
        echo "<option value=\"$key\" >". $key ."</option>";
    }
    echo "</select>";
}

/**
 * Funcion pintaServicio
 *
 * Pinta los titulos de los servicios.
 */
function pintaServicio(){
    $titles=getTituloServicios();
    foreach ($titles as  $value)
        echo "<span>$value</span><br>";
}

/*function pintaServicios($usuario){
    if (!empty($_SESSION['usuarios'][$usuario]['services'])){

        $servicios=$_SESSION['usuarios'][$usuario]['services'];
        foreach ($servicios as $servicio) {
            $cat=implode(" ",$servicio['categoria']);
            echo "<section id=\"".$servicio['titulo']."\">";
            echo "<div>";
            echo "<h2>".$servicio['titulo']."</h2><br>";
            echo "<p>Category: ".$cat."</p><br>";
            echo "<p>Type: ".$servicio['tipo']."</p><br>";
            echo "<p>Price : ".$servicio['precio']." per hour</p>";
            echo "</div>";
            if($servicio["imagen"] != 1){
                echo "<img src=\"".$servicio["imagen"]."\" alt=\"servPicture\">";
            }else{
                echo "<img src=\"../img/imgServ/servdefaultdonotdelete.jpg\" alt=\"servPicture\"></a>";
            }
            echo "</section>";
        }
    }else
        echo"<span>Sin Servicios</span>";
}*/
?>
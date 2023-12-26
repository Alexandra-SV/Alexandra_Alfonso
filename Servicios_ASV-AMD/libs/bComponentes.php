<?php
/****
 * Librería con funciones de generación de componentes
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */
//***** Funciones get **** //

/**
 * Funcion getUser
 *
 * Devuelve datos del usuario indicado.
 *
 * @param string $email
 * @return array|bool
 */
function getUser(string $tabla, string $columna, string $valor, array &$errores, object $pdo): string|bool{
    try {
        $resultado = selectRow($pdo, $tabla, $columna, $valor, $errores);
        if($resultado !== false){ //Usuario encontrado
            return normalArray($resultado); //TODO: QUIEN LO VAYA A USAR COMPROBAR QUE EL NORMALARRAY HACE LO QUE DEBE PORQUE HACE LO QUE QUIERE
        }
    } catch (PDOEXCEPTION $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
    $errores = "Error al buscar el usuario";
    return false;
}

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

//TODO: BORRAR METODOS QUE USEN FICHEROS CUANDO SE HAYAN PASADO A USAR BD
/**
 * Funcion getTituloServicios
 *
 * Devuelve los titulos de los servicios.
 *
 * @return array
 */
/*Con Ficheros antiguo
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
}*/


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
 * @param string $column
 */  
function pintaSelect(array $valores,string $name,bool $idNumerico=TRUE){
    echo "<select name=\"".$name."[]\"id=\"$name\" multiple>";
    $i=1;
    foreach ($valores as  $value) {
        if($idNumerico){
            foreach ($value as $key => $valor) {
                echo "<option value=\"$i\" >". $valor."</option>";
                $i++;
            }
        }else{
            foreach ($value as $key => $valor) {
                echo "<option value=\"$valor\" >". $valor."</option>";
                $i++;
            } 
        }
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
 *
 * @param object $pdo
 * @param string $tabla
 * @param string $columna
 * @param array $errores
 *
 */
function pintaServicio(object $pdo, string $tabla, string $columna, array &$errores){
        $titulos= selectColumn($pdo,$tabla,$columna,$errores);
            foreach ($titulos as $key=>  $value)
        echo "<span>$value[$columna]</span><br>";
}
function pintaServicios(object $pdo, string $tabla,string $columna,string $valor, array &$errores){
    $arrayServicios=selectRow( $pdo, $tabla, $columna, $valor, $errores, "<>");
    $serviciosClean=[];
    if($arrayServicios){
        foreach ($arrayServicios as $key => $value) {
            $serviciosClean["{$value['id_servicios']}"]=
            ['titulo' => $value['titulo'], 'descripcion' => $value['descripcion'], 'precio' => $value['precio'],
            'tipo' => $value['tipo'], 'foto_servicio' => $value['foto_servicio'], 'fecha_alta' => $value['fecha_alta']];

        }
        //doy la vuelta al array para imprimirlo del mas nuevo al mas viejo
        $serviciosClean=array_reverse($serviciosClean);
        foreach ($serviciosClean as $value) {//TODO decide if we show the price even if type is intercambio
        $printTipo=($value['tipo']=="pago")?"<p>".$value['precio']."</p>":"<span></span>";
            $section=
            "<section>
                <a href='../forms/form_unic_service.php'>
                    <img src='".$value['foto_servicio']."' alt='Imagen Servicio'>
                    <div>
                        <p>".$value['titulo']."</p>
                        <p>".$value['descripcion']."</p>
                        <p>".$value['tipo']."</p>
                        $printTipo
                        <p>".$value['fecha_alta']."</p>
                    </div>
                </a>
            </section>";
            echo $section;
        }
    }
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

/**
 * Funcion pintaLista
 *
 * Pinta una lista con los datos de la tabla.
 *
 * @param object $pdo
 * @param string $tabla
 *
 */
function pintaLista(object $pdo, string $tabla, string $columna, array &$errores): string{
    try {
        $resultadoSelect = selectColumn($pdo, $tabla, $columna, $errores);
        if($resultadoSelect){
            $resultadoSelect = normalArray($resultadoSelect);
            $resultado ='<ul>';
            foreach ($resultadoSelect as $key => $value) {
                $resultado .= '<li>' . ucfirst($value) . '</li>';
            }
            $resultado .='</ul>';
            return $resultado;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
}
/**
 * Funcion pintaDesplegableBD
 *
 * Pinta una lista desplegable en un formulario según la tabla.
 *
 * @param object $pdo
 * @param string $tabla
 *
 */
function pintaDesplegableBD(object $pdo, string $tabla, array &$errores): string{
    try {
        $resultadoSelect = selectTable($pdo, $tabla, $errores);
        if($resultadoSelect){
            $resultadoSelect = normalArray($resultadoSelect);
            $resultado ="<select name=\"".$tabla."\"id=\"$tabla\"><option value=\"\" disabled selected hidden>$tabla</option>";
            foreach ($resultadoSelect as $key => $value) {
                if(is_int($value))
                    $resultado .= "<option value=\"".$value."\" >";
                else
                    $resultado .= ucfirst($value) ."</option>";
            }
            $resultado .='</select>';
            return $resultado;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()."##Código: ".$e->getCode()."  ".microtime().PHP_EOL,3,"../log/logBD.txt");
        echo "Error";
    }
}
?>
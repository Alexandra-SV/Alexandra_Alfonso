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
function getUser(string $email): array|bool{
    $datos = file_get_contents("../ficheros/usuarios.txt");
    $datosArray = explode(";",$datos);
    for ($i=0; $i < $datosArray; $i++) {
        $usuario = explode("|",implode("",$datosArray));
        if($usuario[0] == $email)
            return $usuario;
    }
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
 * Pinta un select en un formulario.
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
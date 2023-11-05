<?php
/****
 * Librería con funciones de generación de componentes
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */
 function pintaRadio(array $valores, string $campo){
    for ($i=0; $i < count($valores); $i++) {
        echo "<input type=\"radio\" name=\"$campo\" VALUE=\"$valores[$i]\"> $valores[$i] <br>";
    }
}
function pintaCheck(array $valores, string $campo){
    for ($i=0; $i < count($valores); $i++) {
        echo "<input type=\"checkbox\" name=\"".$campo."[]\" VALUE=\"$valores[$i]\"> $valores[$i] <br>";
    }
}
function pintaSelect(array $valores,string $name){
    echo "<select name=\"".$name."[]\"id=\"$name\" multiple>";
    for ($i=0; $i < count($valores); $i++) {
        echo "<option value=\"$valores[$i]\" >". $valores[$i] ."</option>";
    }
    echo "</select>";
}
function pintaServicios($usuario){
    if (!empty($_SESSION['usuarios'][$usuario]['services'])){
        foreach ($_SESSION['usuarios'][$usuario] as $infoUser) {
            foreach ($infoUser['services'] as $service) {
                echo "<section id=\"".$service['name']."\">";
                echo "<h2>".$service['name']."</h2><br>";
                echo "<p>Category: ".$service['category']."</p><br>";
                echo "<p>Type: ".$service['type']."</p><br>";
                echo "<p>Price : ".$service['price']." per hour</p>";
                echo "<img src=\"".$service['image']."\" alt=\"".$allServices['image']."\">";
                echo "</section>";
            }
        }
    }else
        echo"<span>Sin Servicios</span>";
}

?>
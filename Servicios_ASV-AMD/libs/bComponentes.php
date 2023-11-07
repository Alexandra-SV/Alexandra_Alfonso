<?php
/****
 * Librería con funciones de generación de componentes
 * @author Alexandra Simona Vasilache, Alfonso Marquez Diaz
 *
 */
 function pintaRadio(array $valores, string $campo){
    for ($i=0; $i < count($valores); $i++) {
        echo "<input type=\"radio\" name=\"$campo\" VALUE=\"$valores[$i]\"> $valores[$i] ";
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
        foreach ($_SESSION['usuarios'][$usuario]['services'] as  $service) {
            $cat=implode(" ",$service['categoria']);
            echo "<section id=\"".$service['titulo']."\">";
            echo "<h2>".$service['titulo']."</h2><br>";
            echo "<p>Category: ".$cat."</p><br>";
            echo "<p>Type: ".$service['tipo']."</p><br>";
            echo "<p>Price : ".$service['precio']." per hour</p>";
            echo "<img src=\"".$service['imagen']."\" alt=\"".$service['imagen']."\">";
            echo "</section>";
        }
    }else
        echo"<span>Sin Servicios</span>";
}



function pintaServicio($usuario){
    if (!empty($_SESSION['usuarios'][$usuario]['services'])){
        $cat=implode(" ",$_SESSION['usuarios'][$usuario]['services']['categoria']);
        echo "<section id=\"".$_SESSION['usuarios'][$usuario]['services']['titulo']."\">";
        echo "<div>";
        echo "<h2>".$_SESSION['usuarios'][$usuario]['services']['titulo']."</h2><br>";
        echo "<p>Category: ".$cat."</p><br>";
        echo "<p>Type: ".$_SESSION['usuarios'][$usuario]['services']['tipo']."</p><br>";
        echo "<p>Price : ".$_SESSION['usuarios'][$usuario]['services']['precio']." per hour</p>";
        echo "</div>";
        echo "<img src=\"".$_SESSION['usuarios'][$usuario]['services']['imagen']."\" alt=\"".$_SESSION['usuarios'][$usuario]['services']['imagen']."\">";
        echo "</section>";
    }
}
?>
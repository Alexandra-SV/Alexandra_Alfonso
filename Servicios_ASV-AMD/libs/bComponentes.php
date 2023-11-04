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
    echo "<label for=\"$name\">$name";
    echo "<select name=\"$name\"  multiple=\"multiple\" id=\"$name\">";
    for ($i=0; $i < count($valores); $i++) {
        echo "<option value=\"$valores[$i]\" >". $valores[$i] ."</option";
    }
    echo "</select>";
    echo "</label>";
}
function pintaServicios($usuario){
    foreach ($_SESSION['Usuario'] as $infoUser) {
         if (in_array($usuario,$infoUser.['nombre'])) {
            if ($infoUser.['servicios']){
                foreach ($infoUser['servicios']  as $allServices) {
                    echo "<section id=\"".$allServices['name']."\">";
                    echo "<h2>".$allServices['name']."</h2><br>";
                    echo "<p>Category: ".$allServices['category']."</p><br>";
                    echo "<p>Type: ".$allServices['type']."</p><br>";
                    echo "<p>Price : ".$allServices['price']." per hour</p>";
                    echo "<img src=\"".$allServices['image']."\" alt=\"".$allServices['image']."\">";
                    echo "</section>";
                }
            }else
                echo"<span>Sin Servicios</span>";
        }else
            return false;
    }
}
?>
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
        if($_SESSION['usuarios'][$usuario]['services']["imagen"] != 1){
            echo "<img src=\"".$_SESSION['usuarios'][$usuario]['services']["imagen"]."\" alt=\"servPicture\">";
        }else{
            echo "<img src=\"../img/imgServ/servdefaultdonotdelete.jpg\" alt=\"servPicture\"></a>";
        }
        echo "</section>";
    }else
        echo"<span>Sin Servicios</span>";
}

?>
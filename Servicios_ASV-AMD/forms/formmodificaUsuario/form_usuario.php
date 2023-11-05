<?php 
session_start();
include("../../templates/pl_encabezado.php");
include("../../libs/bGeneral.php");

$Lenguages=["Español","Ingles","Aleman","Frances","Chino"];
$extensionesValidas=["jpeg","jpg","png","gif"];
$errores=[];
$error=false;

//variables que vamos a utilizar
$pass;
$idiomas;
$descripcion;
$nuevaImagen;
$directorio="../../imgs/imgPerfil";

    if (!isset($_REQUEST['bSave'])) {
        include ('../../templates/servicios.php');
    }
    else {
    //sanitizamos    
        $pass=recoge($_POST['Password']);
        $idiomas=recoge($_POST['Lenguages']);
        $descripcion=recoge($_POST['descripcionPersonal']);

        
    //Validamos
    cTexto( $pass,"Password",$errores,25,10);
    cCheck( $idiomas,"Lenguages",$errores,$Lenguages);
    cTexto( $descripcion,"descripcionPersonal",$errores,100);
    $nuevaImagen=cFile($_POST['imagen'],$errores,$extensionesValidas,$directorio,20000,false);
   
    //Comprobamos que no haya errores para crear el servicio
    if (!$errores) {
        $_SESSION['usuarios']['email']['lenguages']=$idiomas;
        $_SESSION['usuarios']['email']['password']=$pass;
        $_SESSION['usuarios']['email']['descripcion']=$descripcion;
        $_SESSION['usuarios']['email']['image']=$nuevaImagen;
    }else
        print_r($errores);
    }
?>	  

<?include("../../templates/pl_tie.html");?>
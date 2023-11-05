<?php 
session_start();
include("../../templates/pl_encabezado.php");
include("../../libs/bGeneral.php");
$categoty=["Informática","Diseño Gráfico","Consultoría Empresarial","Salud y Bienestar","Reparación de Vehículos",
"Enseñanza y Tutoría","Catering y Comida a Domicilio","Guía Turística","Carpintería y Ebanistería","Limpieza y Mantenimiento del Hogar"];
$type=["Pago","intercambio"];
$Availability=["mañanas","tardes","noches"];
$extensionesValidas=["jpeg","jpg","png","gif"];
$errores=[];
$error=false;

//variables que vamos a utilizar
$titulo;
$categoria;
$tipo;
$ubicacion;
$disponibilidad;
$precio;
$imagen;
$directorio="../../imgs/imgPerfil";
$descripcion;
//pintaRadio(array $valores, string $campo);
    if (!isset($_REQUEST['bSave'])) {
        include ('../../templates/servicios.php');
    }
    else {
    //sanitizamos    
        $titulo=recoge($_POST['titulo']);
        $categoria=recoge($_POST['category']);
        $tipo=recoge($_POST['tipo']);
        $ubicacion=recoge($_POST['ubicacion']);
        $disponibilidad=recoge($_POST['Availability']);
        $precio=recoge('precioH');
        $descripcion= recoge('descripcionPersonal',true); 
        
    //Validamos
    cTexto( $titulo,"titulo",$errores,50,8);
    cCheck( $categoria,"categoria",$errores,$categoty);
    radio( $tipo,"tipo",$errores,$type);
    cTexto( $ubicacion,"ubicacion",$errores,50,10);
    cCheck( $disponibilidad,"disponibilidad",$errores,$Availability);
    cNum( $precio,"precioH",$errores);
    cTexto( $descripcion,"descripcionPersonal",$errores,100);
    $imagen=cFile($_POST['servicePicture'],$errores,$extensionesValidas,$directorio,20000,false);
    //Comprobamos que no haya errores para crear el servicio
    if (!$errores) {
        $servicio = array(
            "titulo" => $titulo  ,
            "categoria" => $categoria  ,
            "tipo" => $tipo  ,
            "ubicacion" => $ubicacion  ,
            "disponibilidad" => $disponibilidad  ,
            "precio" => $precio  ,
            "imagen" => $imagen  ,
            "descripcion" => $descripcion ,
            "services" => [] 
        ); 
        $_SESSION['servicio'][$titulo]=$servicio;
    }else
        print_r($errores);
    }
?>	  

<?include("../../templates/pl_tie.html");?>










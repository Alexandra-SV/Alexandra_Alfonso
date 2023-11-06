<?php 
if(!isset($_SESSION)) session_start();
include("../templates/pl_encabezado.php");
include("../libs/bGeneral.php");

$category=["Informática","Diseño Gráfico","Consultoría Empresarial","Salud y Bienestar",
"Reparación de Vehículos","Enseñanza y Tutoría","Catering y Comida a Domicilio","Guía Turística",
"Carpintería y Ebanistería","Limpieza y Mantenimiento del Hogar"];

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
$descripcion;
//imagen
$imagen;
$dir="../../imgs/imgServicios";//crear folder
$max_file_size = "2000000";

$user = recoge('user');// = ""
/*if($user == ""){
  header('location:../forms/formInicioSesion.php');
}*/
//$email=$_SESSION['usuarios'][$user]['email']; Warning :Trying to access array offset on value of type null 

    if (!isset($_REQUEST['bSave'])) {
        include ('../templates/servicios.php');
    }
    else {
    //sanitizamos    
        $titulo=recoge('titulo',true);
        $categoria=recogeArray('category'); 
        $tipo=recoge('tipo');
        $ubicacion=recoge('ubicacion',true);
        $disponibilidad=recogeArray('Availability'); 
        $precio=recoge('precioH');
        $descripcion= recoge('descripcionPersonal',true); //=""
        
    //Validamos
    cTexto( $titulo,"titulo",$errores,50,8);
    cCheck( $categoria,"categoria",$errores,$category); 
    cRadio( $tipo,"tipo",$errores,$type);
    cTexto( $ubicacion,"ubicacion",$errores,50,10);
    cCheck( $disponibilidad,"disponibilidad",$errores,$Availability);
    cNum( $precio,"precioH",$errores);
    cTexto( $descripcion,"servicedescription",$errores,100);
    $imagen=cFile('servicePicture',$errores,$extensionesValidas,$dir,$max_file_size,false);// Return value must be of type string|bool, none returned
    
    //Comprobamos que no haya errores para crear el servicio
    if (empty($errores)) {
        $servicio = array(
            "titulo" => $titulo  ,
            "categoria" => $categoria  ,
            "tipo" => $tipo  ,
            "ubicacion" => $ubicacion  ,
            "disponibilidad" => $disponibilidad  ,
            "precio" => $precio  ,
            "imagen" => $imagen  ,
            "descripcion" => $descripcion 
        ); 
        $_SESSION['usuarios'][$user]["services"]=$servicio;
        header("location:form_mainpage.php?user=$email");//va a la pag principal del usuario ?
    }else
        include("../templates/servicios.php");
    }
?>	  

<?include("../templates/pl_pie.html");?>
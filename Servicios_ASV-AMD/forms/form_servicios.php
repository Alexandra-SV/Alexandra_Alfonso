<?php
session_start();
include("../libs/bGeneral.php");
setTimer('timeout',300);
include("../libs/bConfiguracion.php");

$errores=[];
$error=false;

//variables a utilizar
$titulo;
$categoria;
$tipo;
$ubicacion;
$disponibilidad;
$precio;
$descripcion;
$imagen;

//Cambia la cookie
$color = "";
$errores = [];
if(isset($_REQUEST['bChange'])){
    $color = recoge('colorFondo');
    cRadio($coloresCookie[$color],'colorFondo',$errores,$coloresCookie,false);
    if(empty($errores)){
    setcookie('fondo',$coloresCookie[$color]);
    }
}
//Comporbacion parte privada
if($_SESSION['access'] != 1 || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
    header("location:formInicioSesion.php");
};
$user = $_SESSION['active'];
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
        $descripcion= recoge('servicedescription',true);

    //Validamos
    cTexto( $titulo,"titulo",$errores,50,3);
    cCheck( $categoria,"categoria",$errores,$category);
    cRadio( $tipo,"tipo",$errores,$type);
    cTexto( $ubicacion,"ubicacion",$errores,50);
    cCheck( $disponibilidad,"disponibilidad",$errores,$Availability);
    cNum( $precio,"precioH",$errores);
    cTextarea( $descripcion,"servicedescription",$errores,100,0,false);

    if($descripcion=="")$descripcion="-";

    //Comprobamos que no haya errores para crear el servicio
    if (empty($errores)) {
        $imagen=cFile('servicePicture',$errores,$extensionesValidas,$dirServicio,$max_file_size,false);
        if(empty($errores)){
            if($imagen==1)
                $imagen="../img/imgServ/servdefaultdonotdelete.jpg" ;
            $st= $titulo."|".implode(',',$categoria)."|".$tipo."|".$ubicacion."|".implode(',',$disponibilidad)."|".$precio."|".$imagen."|".$descripcion."|".date("d-m-Y h:i:s",time()).PHP_EOL;
            file_put_contents("../ficheros/servicios.txt",$st,FILE_APPEND);
            header("location:form_mainpage.php");
        }else
            include("../templates/servicios.php");
    }else
        include("../templates/servicios.php");
    }
?>

<?include("../templates/pl_pie.html");?>
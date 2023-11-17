<?php
session_start();
include("../templates/pl_encabezado.php");
include("../libs/bGeneral.php");
include("../libs/bConfiguracion.php");

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


$user = $_SESSION['active'];
if($user == ""){
  header('location:../forms/formInicioSesion.php');
}
$email=$_SESSION['usuarios'][$user]['email'];

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
        $descripcion= recoge('servicedescription',true); //=""

    //Validamos
    cTexto( $titulo,"titulo",$errores,50,3);
    cCheck( $categoria,"categoria",$errores,$category);
    cRadio( $tipo,"tipo",$errores,$type);
    cTexto( $ubicacion,"ubicacion",$errores,50);
    cCheck( $disponibilidad,"disponibilidad",$errores,$Availability);
    cNum( $precio,"precioH",$errores);
    cTextarea( $descripcion,"servicedescription",$errores,100,0);

    //Comprobamos que no haya errores para crear el servicio
    if (empty($errores)) {
        $imagen=cFile('servicePicture',$errores,$extensionesValidas,$dirSesion,$max_file_size,false);
        if(empty($errores)){//cambiar luego para mostrar error directamente y no que introduzca la default
            if($imagen==1)
                $imagen="../img/imgServ/servdefaultdonotdelete.jpg" ;
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
            $st= $titulo."|".implode(',',$categoria)."|".$tipo."|".$ubicacion."|".implode(',',$disponibilidad)."|".$precio."|".$imagen."|".$descripcion."|".date("d-m-Y h:i:s",time());
            file_put_contents("../ficheros/servicios.txt",$st.PHP_EOL,FILE_APPEND);
            //añade al usuario   array_push($_SESSION['usuarios'][$user]["services"], $servicio);//$_SESSION['usuarios'][$user]["services"][]=$servicio;
            header("location:form_mainpage.php");
        }else{
            //$imagen="../img/imgServ/servdefaultdonotdelete.jpg";
            include("../templates/servicios.php");
        }
        
    }else
        include("../templates/servicios.php");
    }
?>


<?include("../templates/pl_pie.html");?>
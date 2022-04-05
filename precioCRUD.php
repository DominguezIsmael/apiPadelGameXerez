<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
include('./configuracion.inc.php');
$conexionBD = mysqli_connect($servidor, $usuario, $passwddb);
mysqli_select_db($conexionBD,$nombreBaseDatos);
mysqli_query($conexionBD,"SET NAMES utf8");


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlprecio = mysqli_query($conexionBD,"SELECT * FROM precio WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlprecio) > 0){
        $precio = mysqli_fetch_all($sqlprecio,MYSQLI_ASSOC);
        echo json_encode($precio);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
// borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlprecio = mysqli_query($conexionBD,"DELETE FROM precio WHERE id=".$_GET["borrar"]);
    if($sqlprecio){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $dia=$data->dia;
    $precio_normal=$data->precio_normal;
    $precio_socio=$data->precio_socio;
    if(($dia!="")&&($precio_normal!="")&&($precio_socio!="")){
            
    $sqlprecio = mysqli_query($conexionBD,"INSERT INTO precio(dia,precio_normal,precio_socio)
                                                        VALUES('$dia','$precio_normal','$precio_socio') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));
    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $dia=$data->dia;
    $precio_normal=$data->precio_normal;
    $precio_socio=$data->precio_socio;
    $sqlprecio = mysqli_query($conexionBD,"UPDATE precio SET dia='$dia',precio_normal='$precio_normal',precio_socio='$precio_socio' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla precio
$sqlprecio = mysqli_query($conexionBD,"SELECT * FROM precio ");
if(mysqli_num_rows($sqlprecio) > 0){
    $precio = mysqli_fetch_all($sqlprecio,MYSQLI_ASSOC);
    //var_dump($precio);
    echo json_encode($precio);
}
else{ echo json_encode([["success"=>0]]); }


?>

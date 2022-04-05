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
    $sqlCliente = mysqli_query($conexionBD,"SELECT * FROM cliente WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlCliente) > 0){
        $cliente = mysqli_fetch_all($sqlCliente,MYSQLI_ASSOC);
        echo json_encode($cliente);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
// borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlCliente = mysqli_query($conexionBD,"DELETE FROM cliente WHERE id=".$_GET["borrar"]);
    if($sqlCliente){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $apellidos=$data->apellidos;
    $email=$data->email;
    $password=$data->password;
    $socio=$data->socio;
    $nivel=$data->nivel;
    $fechanacimiento=$data->fechanacimiento;
    $telefono=$data->telefono;
        if(($apellidos!="")&&($nombre!="")&&($email!="")&&($password!="")&&($socio!="")&&($nivel!="")&&($fechanacimiento!="")&&($telefono!="")){
            
    $sqlCliente = mysqli_query($conexionBD,"INSERT INTO cliente(nombre,apellidos,email,password,socio,nivel,fechanacimiento,telefono)
                                                        VALUES('$nombre','$apellidos','$email',md5('$password'),'$socio','$nivel','$fechanacimiento','$telefono') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombre=$data->nombre;
    $apellidos=$data->apellidos;
    $email=$data->email;
    $password=$data->password;
    $socio=$data->socio;
    $nivel=$data->nivel;
    $fechanacimiento=$data->fechanacimiento;
    $telefono=$data->telefono;
    $sqlCliente = mysqli_query($conexionBD,"UPDATE cliente SET nombre='$nombre',apellidos='$apellidos',email='$email',password=md5('$password'),socio='$socio',nivel='$nivel',fechanacimiento='$fechanacimiento', telefono='$telefono' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla cliente
$sqlCliente = mysqli_query($conexionBD,"SELECT * FROM cliente ");
if(mysqli_num_rows($sqlCliente) > 0){
    $cliente = mysqli_fetch_all($sqlCliente,MYSQLI_ASSOC);
    //var_dump($cliente);
    echo json_encode($cliente);
}
else{ echo json_encode([["success"=>0]]); }


?>

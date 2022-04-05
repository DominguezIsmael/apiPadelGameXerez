<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
$email =$data->email;
$password =$data->password;

include('configuracion.inc.php');
$conexionBD = new mysqli($servidor, $usuario, $passwddb, $nombreBaseDatos);

$sqlLogin = mysqli_query($conexionBD,"SELECT * FROM cliente WHERE email='$email' AND password='$password'");

if(mysqli_num_rows($sqlLogin) > 0){
    $login = mysqli_fetch_all($sqlLogin, MYSQLI_ASSOC);
    echo json_encode($login);
    exit();
}
else{ echo json_encode(["success"=>0]); }
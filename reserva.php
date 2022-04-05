<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ("configuracion.inc.php");
$c = new Mysqli($servidor,$usuario,$passwddb,$nombreBaseDatos);
$data = json_decode(file_get_contents("php://input"));

$nombre=$data->nombre;
$fecha=$data->fecha;
$hora=$data->hora;
$pista=$data->pista;
$cliente=$data->cliente;

// Obtengo los datos del cliente

$resultado = $c->query("SELECT socio FROM cliente WHERE id='$cliente'");
$linea = $resultado->fetch_assoc();
$es_socio = $linea['socio']);

$diasemana = date("%w");

switch ($diasemana){
    case 1,2,3,4,5 : // entre semana
        if ($es_socio == 'N'){
            $resultado = $c->query("SELECT precio_normal AS precio from precio WHERE dia='Entre semana'");
            $linea = $resultado->fetch_assoc();
            $precio = $linea['precio']);
        }else{
            $resultado = $c->query("SELECT precio_socio AS precio from precio WHERE dia='Entre semana'");
            $linea = $resultado->fetch_assoc();
            $precio = $linea['precio']);
        }
    default // fin de semana
    if ($es_socio == 'N'){
        $resultado = $c->query("SELECT precio_normal AS precio from precio WHERE dia='Fin de semana'");
        $linea = $resultado->fetch_assoc();
        $precio = $linea['precio']);
    }else{
        $resultado = $c->query("SELECT precio_socio AS precio from precio WHERE dia='Fin de semana'");
        $linea = $resultado->fetch_assoc();
        $precio = $linea['precio']);
    }
}

// SELECT CON FECHA HORA Y PISTA PARA VER SI YA EXISTE ESA RESERVA

$resultadoexiste = $c->query("SELECT id FROM reserva WHERE fecha='$fecha' AND hora='$hora' AND pista_id='$pista'");
if($resultadoexiste->num_rows > 0) { //SI EXISTE DEVULVE ERROR
    echo json_encode(["success"=>0]);
}
else { //SI NO EXISTE INSERTAS
    if(($nombre!="")&&($reserva!="")&&($hora!="")&&($cliente!="")&&($pista!="")&&($precio!="")){
    $sqlReserva = $c->query("INSERT INTO reserva(nombre,fecha,hora,cliente_id,pista_id,precios_id)
                                        VALUES ('$nombre','$fecha','$hora','$cliente','$pista','$precio')");
    echo json_encode(["success"=>1]);
    }
}



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./Clases/DireccionIpClass.php');
require_once('./Clases/LogErrorClass.php');
require_once('./Constantes/Constantes.php');

header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

if (isset($_POST["ip"])) {	
	$ipPost = htmlspecialchars(strip_tags($_POST["ip"]));
	$ip = new DireccionIp();
	if($ip->validarIP($ipPost)){
		try {
			$ipArray = [];
			array_push($ipArray,$ipPost);
			
			$baseDeDatos = new BaseDeDatos(BASEDEDATOS_IP ,BASEDEDATOS_PORT,BASEDEDATOS_BASE,BASEDEDATOS_USUARIO,BASEDEDATOS_PASSWORD);

			//INET6_NTOA convierte de varbinary a ip
			
			$sql = "DELETE FROM ". TABLA_IPFILTER . 
					" WHERE ip= INET6_ATON('".$ipPost."');";
					
			$resultado = $baseDeDatos->ejecutarConsultaSQL($sql);
			
			http_response_code(200);
			echo json_encode(array("mensaje" => "Si la ip existia en la Base de Datos ha sido eliminada"));
		} catch (Exception $e) {
			$log = new LogError("Archivo: ".$e->getFile(). " | Mensaje: ".$e->getMessage());
			$log->grabarError();
			http_response_code(503);
			echo json_encode(array("mensaje" => "Problemas tecnicos"));
		} 
	} else {
		http_response_code(404);
		echo json_encode(array("mensaje" => "Parametro incorrecto"));
	}
} else {
	http_response_code(404);
	echo json_encode(array("mensaje" => "Parametro No enviado"));
}

?>

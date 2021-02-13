<?php

require_once ('./Clases/LogErrorClass.php');	
require_once('./Clases/BaseDeDatosClass.php');
require_once('./Constantes/Constantes.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

try {
	$baseDeDatos = new BaseDeDatos(BASEDEDATOS_IP ,BASEDEDATOS_PORT,BASEDEDATOS_BASE,BASEDEDATOS_USUARIO,BASEDEDATOS_PASSWORD);

	//INET6_NTOA convierte de varbinary a ip
	$sql = "Select INET6_NTOA(ip) as direccion from ". TABLA_IPWEB . ";";	

	$resultado = $baseDeDatos->ejecutarConsultaSQL($sql);

	$json = array();
	$i=0;
	if ($resultado) {
		$valorQuery = "";
		while ($baseDeDatos->obtenerValorQuery($valorQuery)){
			array_push($json, $valorQuery["direccion"]	);
			$i++;
		}
	}	

	if (count($json) != 0){ //hay ips
		http_response_code(200);
		echo json_encode($json);
	} else {
		http_response_code(404);
		array_push($json, "Sin Resultados");
		echo json_encode($json);
	}
	
} catch (Exception $e) {
	$log = new LogError("Archivo: ".$e->getFile(). " | Mensaje: ".$e->getMessage());
	$log->grabarError();
	http_response_code(503);
	echo json_encode(array("mensaje" => "Problemas tecnicos"));
}	

?>

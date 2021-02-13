<?php

require_once('./Clases/DireccionIpClass.php');
require_once('./Clases/BaseDeDatosClass.php');
require_once('./Constantes/Constantes.php');
require_once ('./Clases/LogErrorClass.php');

header('Content-Type: application/json');

try {
	$baseDeDatos = new BaseDeDatos(BASEDEDATOS_IP ,BASEDEDATOS_PORT,BASEDEDATOS_BASE,BASEDEDATOS_USUARIO,BASEDEDATOS_PASSWORD);

	//INET6_NTOA convierte de varbinary a ip
	$sql =  "SELECT INET6_NTOA(ip) as direccion ".
			"FROM ". TABLA_IPWEB . 
			" WHERE NOT EXISTS (SELECT ip ".
							   " FROM " . TABLA_IPFILTER .
							   " WHERE " .TABLA_IPWEB .".ip = " . TABLA_IPFILTER .".ip);";

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

	if (count($json) != 0){ //hay Ips para devolver
		http_response_code(200);
		echo json_encode($json);
	} else {
		http_response_code(404);
		echo json_encode(array("mensaje" => "Sin Resultados"));
	}
} catch (Exception $e) {
	$log = new LogError("Archivo: ".$e->getFile(). " | Mensaje: ".$e->getMessage());
	$log->grabarError();
	http_response_code(503);
	echo json_encode(array("mensaje" => "Problemas tecnicos"));
}

?>

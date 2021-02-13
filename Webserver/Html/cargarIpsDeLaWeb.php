<?php
require_once ('./Clases/DireccionIpClass.php');
require_once ('./Clases/LectorWebClass.php');
require_once ('./Clases/LogErrorClass.php');
require_once ('./Constantes/Constantes.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');


try {
	$baseDeDatos = new BaseDeDatos(BASEDEDATOS_IP ,BASEDEDATOS_PORT,BASEDEDATOS_BASE,BASEDEDATOS_USUARIO,BASEDEDATOS_PASSWORD);
	//Se deja la tabla vacia
	$sql = "Delete from ". TABLA_IPWEB . ";";	

	$resultado = $baseDeDatos->ejecutarConsultaSQL($sql);

	$web = new LectorDeWebs(DIR_WEB);
	
	//chr(10) -> fin de linea
	$listaDeIps = explode(chr(10), $web->getWeb());
	
	$ips = new DireccionIP();

	if (count($listaDeIps)>0){
			$ipsAgregados = $ips->agregarIpsDeWebsite($listaDeIps);
		if($ipsAgregados>0){
			http_response_code(200);
			echo json_encode(array("mensaje" => $ipsAgregados . " Ips agregados"));
		} else {
			throw new Exception("Error lista vacia o corrupta");
		}
	}
	

} catch (Exception $e) {
	$log = new LogError("Archivo: ".$e->getFile(). " | Mensaje: ".$e->getMessage());
	$log->grabarError();
	http_response_code(503);
	echo json_encode(array("mensaje" => "Problemas tecnicos"));
}	

?>

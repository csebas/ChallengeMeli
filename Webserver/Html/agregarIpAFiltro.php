<?php
require_once('./Clases/DireccionIpClass.php');
require_once('./Clases/LogErrorClass.php');

header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

if (isset($_POST["ip"])) {	
	$ipPost = htmlspecialchars(strip_tags($_POST["ip"]));
	$ip = new DireccionIp();
	if($ip->validarIP($ipPost)){
		$ipArray = [];
		array_push($ipArray,$ipPost);
		if ($ip->agregarIpAListaDeFiltros($ipArray) > 0){
			http_response_code(200);
			echo json_encode(array("mensaje" => "Ip agregado"));
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

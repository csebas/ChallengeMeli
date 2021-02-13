<?php

require_once('./Clases/LogErrorClass.php');

Class LectorDeWebs {
	private $web ="";
	
	// $url es la direccion de la web a leer
	//El resultado de la web lo guarda en el parametro privado web
	//En caso de error lanza excepcion.
	public function __construct ($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //devuelve la web
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //para no verificar el cert (no prod)
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION , true); //redirect
		$resultadoWeb = curl_exec($ch);
		if (!curl_errno($ch)) {
			switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
				case 200: 
					break;
				default:
					throw new Exception('Unexpected HTTP code: ', $http_code, "\n");
			}
		}

		curl_close($ch);
		$this->web = $resultadoWeb;
	}
	
	public function getWeb(){
		return $this->web;
	}
	
}

?>

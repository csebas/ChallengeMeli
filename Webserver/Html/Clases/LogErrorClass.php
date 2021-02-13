<?php

require_once('BaseDeDatosClass.php');
require_once('./Constantes/Constantes.php');

Class LogError {
	
	private $error;
	
	function __construct($error){
		$this->error = $error;
	}

	public function devolverError(){
		
		if (isset($error)){
			return $this->error;
		} else {
			return "";
		}
	}	
				
	public function grabarError(){
		try {
			if (file_exists(DIR_ARCHIVO_LOG)) {
				if (is_writable(DIR_ARCHIVO_LOG)){
					$archivo = fopen(DIR_ARCHIVO_LOG, "a");
					fwrite($archivo, "Fecha: " . date_create()->format('Y-m-d H:i:s') . " | ".$this->error . "\n");
					fclose($archivo);
				}
			} 
		} catch (Exception $e) {
				http_response_code(504);
				echo json_encode(array("mensaje" => "Problemas tecnicos"));
		}
	}
	
	
}



?>

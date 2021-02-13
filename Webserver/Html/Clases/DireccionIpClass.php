<?php
require_once('BaseDeDatosClass.php');
require_once('./Constantes/Constantes.php');

class DireccionIP {
	
		function __construct() {
		}			
	 
		//Valida si una IPv4 o IPv6 es correcta
		function validarIP($ip){
			if (strlen($ip) < 1) return false;
			if (filter_var($ip, FILTER_VALIDATE_IP)) {
				return true;
			} else {
				return false;
			}
		}
		
	
		//Agrega un array de IPs a la tabla completa
		//Devuelve cuantos registros grabo
		public function agregarIpsDeWebsite($ips){
			$tabla = TABLA_IPWEB;
			return $this->grabarVariosIpsEnTabla($tabla,$ips);
		}
		
		//Agrega un array de IPs a la tabla de Filtros.	
		//Devuelve cuantos registros grabo
		public function agregarIpAListaDeFiltros($ips){
			$tabla = TABLA_IPFILTER;
			return $this->grabarVariosIpsEnTabla($tabla,$ips);
			 
		}
		
		//Graba IPs en la base de datos, segun la tabla que se le envie por parametro
		//Devuelve la cantidad de registros grabados
		//En caso de error lanza una excepcion
		function grabarVariosIpsEnTabla($tabla, $ips) {
			try {
				$baseDeDatos = new BaseDeDatos(BASEDEDATOS_IP ,BASEDEDATOS_PORT,BASEDEDATOS_BASE,BASEDEDATOS_USUARIO,BASEDEDATOS_PASSWORD);
				
				$i = 0;
				$cantidad = count($ips);
				$parteDelInsert = '';
				$cantidadInsertados=0;
				while ($i < $cantidad){
					if($this->validarIP($ips[$i])){
						$parteDelInsert = $parteDelInsert . "(INET6_ATON('". $ips[$i] ."')),";
						$cantidadInsertados++;
					}
					$i++;
					if (($i == $cantidad or $i == NUM_MAX_INSERT) AND ($cantidadInsertados >0)){
						$tamanioSql = strlen($parteDelInsert);
						$parteDelInsert[$tamanioSql-1]=";";
						$sql = "INSERT into ". $tabla.
								" (ip) ".
								"values ".
									$parteDelInsert;
						$baseDeDatos->ejecutarConsultaSQL($sql);
						$parteDelInsert = '';
						}
				}
				return $cantidadInsertados;
			} catch (Exception $e) {
							$log = new LogError("Archivo: ".$e->getFile(). " | Mensaje: ".$e->getMessage());
							$log->grabarError();
							http_response_code(503);
							echo json_encode(array("mensaje" => "Problemas tecnicos"));
						}

		}
}
?>

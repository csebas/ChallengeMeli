<?php

require_once('./Constantes/Constantes.php');

Class BaseDeDatos {
	
	private $conn;
	private $resultadoQuery;
	private $contador = 0;
	
	//inicializa la conexion
	function __construct($ip ,$puerto,$db,$usuario,$pass){
		$this->conn = new mysqli($ip.":".$puerto, $usuario, $pass, $db);
		if ($this->conn->connect_error) {
			throw new Exception("Error alconectarse con Mysql: " . $this->conn->connect_error);
		} 
	}
	
	//Dada una query ejecuta la consulta
	//En caso de error lanza una excepcion
	function ejecutarConsultaSQL($sql) {
		$this->resultadoQuery = $this->conn->query($sql);
		if ($this->conn->error != '') {
			throw new Exception("Error descripcion: " . $this->conn-> error);
		}
		return true;
	}
		
	//Recibo por parametro referencia a un array
	//Devuelve una tupla de la query
	function obtenerValorQuery(&$valorQuery){
		if (mysqli_num_rows($this->resultadoQuery) > 0) {
			if ($valorQuery = mysqli_fetch_assoc($this->resultadoQuery)){
				return true;
			} else { 
				return false;
			}
		}
	}	
	
	function cerrarConexion(){
		if (!$this->conn->close()){
			throw new Exception("Error al cerrar la conexion");
		} 
	}	
		
	function __destruct(){ 
		if (!$this->conn->close()){
			throw new Exception("Error al cerrar la conexion");
		}
	}  	
}


?>

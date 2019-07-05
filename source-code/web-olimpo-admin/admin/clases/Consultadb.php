<?
include "DoSQL.php";
class ConsultaBD{

	/*variables de conexión*/

	var $server = "127.0.0.1";
	var $user = "olimpo";
	var $pass = "valencia";
   	var $db = "olimpohouse_com";		   
	/*
		var $server = "127.0.0.1";
	var $user = "babait2";
	var $pass = "07qqhm66";
   	var $db = "babait_dos";	
	funcion conectar
	entradas=ninguna
	salidas=identificador de conexión a base de datos $db
	*/
	function conectar()
	{
        $conectar=mysql_connect($this->server,$this->user,$this->pass);
		mysql_select_db($this->db);
		return $conectar;
	}
	/*
	funcion desconectar
	entradas=identificador de conexión
	salidas=ninguna
	*/
	
    function desconectar($conexionID){
         mysql_close($conexionID);
    }	
}
?>
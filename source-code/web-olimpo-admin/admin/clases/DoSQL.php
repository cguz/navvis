<?
class DoSQL{

	/*
	funcion query
	entradas=consulta sql
	salidas=resultado
	*/
		
    function query($query)
    {
         
		 $resultado= mysql_query($query);
		 return($resultado);
    }

	/*
	funcion obtener_filas
	entradas=consulta sql
	salidas=devuelve la primer fila de la consulta
	*/	

    function Obtener_fila($query)
    {
         $result= mysql_query($query);
		 $resultado = mysql_fetch_row($result);
         return($resultado);
    }
	
	/*
	funcion obtener_filas
	entradas=consulta sql
	salidas=arreglo con los resultados de la consulta
	*/
	
	function obtener_filas($sql)
	{
		 $result = array();
		 if ($query = mysql_query($sql))
			{
			 while ($row = mysql_fetch_row($query))
			 {
				 $result[]= $row;
			 }
			 return $result;
			 }
		 return false;
	}
		
	/*
	funcion obtener_columna
	entradas=consulta sql solicitando un unico campo
	salidas=arreglo con los resultados de la columna solicitada
	*/
	
    function Obtener_columna($query)
    {
		 $result= mysql_query($query);
		 $i=0;
		 $resultado = array();
		 while($row = mysql_fetch_row($result))
		 {
		 	$resultado[$i]=$row[0];
			$i++;
		 }
         return $resultado;
    }	
	
	/*
	funcion obtener_cantidad
	entradas=consulta sql
	salidas=devuelve la cantidad de filas de la consulta
	*/	

    function Obtener_cantidad($query)
    {
         $result= mysql_query($query);
		 $resultado = mysql_num_rows($result);
         return($resultado);
    }	

	/*
	funcion Obtiene el ultimo registro echo en el campo ingresado
	entradas=tabla,campo
	salidas=devuelve la ultima id registrada en la tabla
	*/	
		
	function ObtenerUltimoReg($tabla,$campo)
	{
		$sql="SELECT $campo FROM $tabla ORDER BY $campo DESC";
        $result= mysql_query($sql);
		$resultado = mysql_fetch_row($result);
		return $resultado;
	}		
}
?>
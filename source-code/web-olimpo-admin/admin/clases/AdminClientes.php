<?
class AdminClientes{

	/*
	variables de configuracion de clase
	*/
	var $tabla_clientes = "inmueble_cliente";
	var $tabla_inmobiliaria = "inmueble_inmobiliaria";
	
	/*
	funcion Obtenerclientes
	entradas=
	salidas=Arreglo [id][seccion] de todas las clientes activas
	*/	
	function ObtenerCliente($patern)
	{
		$tabla=$this->tabla_clientes;
		$sql="SELECT Id,Nombre,Apellidos,Telefono, Celular, Email, Direccion, Codigopostal, Ciudad, puerta, escalera, numero, calle, planta, observacion_oculta, tipo_cliente FROM $tabla WHERE patern='$patern' ORDER BY id";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	
	/*
	funcion ObtenerDatosCli
	entradas=id de usuario
	salidas=arreglo con información de la sección Id
	*/	
				
	function ObtenerDatosCli($id)
	{
		$tabla=$this->tabla_clientes;
		$sql="SELECT Id, Nombre,Apellidos,Telefono, Email, Celular, Direccion, Codigopostal, Ciudad, puerta, escalera, numero, calle, planta, observacion_oculta, tipo_cliente FROM $tabla WHERE Id='$id'";
//		echo $sql;
		$datos=Dosql::obtener_fila($sql);
		return $datos;
	}	
	
	/*
	funcion ObtenerCliPorCampo
	entradas=cadena de busqueda,campo en que se debe buscar
	salidas=arreglo con is de todos los usuarios
	*/	
	function ObtenerCliPorCampo($buscar,$campo, $tipo_cliente)
	{
		$tabla=$this->tabla_clientes;
		if ($tipo_cliente != 0)
			$tipo_cliente = " AND tipo_cliente=$tipo_cliente";
		else
			$tipo_cliente ="";
			
		if ($campo=="Telefono")
			$sql="SELECT Id FROM $tabla WHERE $campo LIKE '%$buscar%' OR Celular LIKE '%$buscar%'".$tipo_cliente;	
		else
			$sql="SELECT Id FROM $tabla WHERE $campo LIKE '%$buscar%'".$tipo_cliente;
		//echo $sql;
		$id_usr=Dosql::obtener_columna($sql);
		return $id_usr;
	}	
	
	/*
	funcion ObtenerCliPorId
	entradas=id de usuario
	salidas=arreglo con información de la sección Id
	*/	
				
	function ObtenerCliPorId()
	{
		$tabla=$this->tabla_clientes;
		$sql="SELECT Id FROM $tabla order by Id desc";
		$datos=Dosql::obtener_columna($sql);
		return $datos;
	}	
	
	/*
	funcion EliminarSec
	entradas=id de usuario
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function EliminarCli($id)
	{
		$tabla=$this->tabla_clientes;
		$tabla_inmo=$this->tabla_inmobiliaria;
		$sql="DELETE FROM $tabla_inmo WHERE Id_cliente='$id'";
		$datos=Dosql::query($sql);		
		$sql="DELETE FROM $tabla WHERE Id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}		
	
	/*
	funcion ActualizarDatosSec
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function ActualizarDatosCli($id,$nombre, $apellidos, $telefono, $email,$celular, $direccion, $codigopostal, $ciudad, $puerta, $escalera, $numero, $calle,$planta, $observacion_oculta, $tipo_cliente)
	{
		if ($numero=='')
			$numero=0;
		if ($puerta=='')
			$puerta=0;
		$tabla=$this->tabla_clientes;
		$sql="UPDATE $tabla SET Nombre='$nombre',Apellidos='$apellidos',Telefono='$telefono',Celular='$celular',Email='$email',Direccion='$direccion',Codigopostal='$codigopostal',Ciudad='$ciudad', puerta='$puerta', escalera='$escalera', numero=$numero, calle='$calle', planta='$planta', observacion_oculta='$observacion_oculta', tipo_cliente=$tipo_cliente WHERE Id=$id";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	
	
	/*
	funcion InsertarDatosSec
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	//Validar campos vacios
	function InsertarDatosCli($nombre, $apellidos, $telefono, $celular, $email, $direccion, $codigopostal, $ciudad, $puerta, $escalera, $numero, $calle, $planta, $observacion_oculta, $tipo_cliente)
	{
		$tabla=$this->tabla_clientes;
		$sql="SELECT * FROM $tabla WHERE Email='$email'";
		$datos=Dosql::obtener_cantidad($sql);

		if ($numero=='')
			$numero=0;
		if ($puerta=='')
			$puerta=0;
		
		$datos=0;
		if($datos==0)
		{
			$sql="INSERT INTO $tabla VALUES ('','$nombre','$apellidos','$telefono','$celular','$email','$direccion','$codigopostal','$ciudad', '$puerta', '$escalera', $numero, '$calle','$planta', '$observacion_oculta', $tipo_cliente)";
			$datos=Dosql::query($sql);
		}else{
			$datos="existe";
		}
		//echo $sql;
		return $datos;
	}			
	
	/*
	funcion ObtenerUltimoId
	entradas=ninguno
	salidas=ultimo id registrado en la tabla de usuarios
	*/	
		
	function ObtenerUltimoId()
	{
		$tabla=$this->tabla_clientes;
		$datos=Dosql::ObtenerUltimoReg($tabla,'id');
		return $datos[0];
	}	
	
	function GenerarXml($tags,$ruta)
	{
		$cadena="<?xml version='1.0'?>\n
				<bjork>\n
				$tags
				</bjork>";
		$archivo=fopen($ruta,"w+");
		fwrite($archivo,utf8_encode(str_replace("\n","",$cadena)));
		fclose($archivo);
	}
}
?>
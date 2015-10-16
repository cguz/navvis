<?
class AdminInmuebles{

	/*
	variables de configuracion de clase
	*/
	var $tabla_clientes = "inmueble_cliente";
	var $tabla_inmuebles = "inmueble_inmobiliaria";
	var $tabla_poblacion="inmueble_poblacion";
	var $tabla_tipo="inmueble_tipo";
	var $tabla_inmuebles_imagenes = "inmueble_inmobiliaria_imagenes";
	
	/*
	funcion Obtenerclientes
	entradas=
	salidas=Arreglo [id][seccion] de todas las clientes activas
	*/	
	function ObtenerCliente($patern)
	{
		$tabla=$this->tabla_clientes;
		$sql="SELECT Id,Nombre,Apellidos,Telefono, Celular, Email, Direccion, Codigopostal, Ciudad, puerta, escalera, numero, calle, planta FROM $tabla WHERE estado='$patern' ORDER BY Id";
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
		$sql="SELECT Id, Nombre,Apellidos,Telefono, Email, Celular, Direccion, Codigopostal, Ciudad, puerta, escalera, numero, calle, planta FROM $tabla WHERE Id='$id'";
		$datos=Dosql::obtener_fila($sql);
		return $datos;
	}	
	
	/*
	funcion ObtenerDatosInmue
	entradas=id de usuario
	salidas=arreglo con información de la sección Id
	*/	
				
	function ObtenerDatosInmue($id)
	{
		$tabla=$this->tabla_inmuebles;
		$sql="SELECT Id_cliente, Id, poblacion, orientacion, codigopostal, direccion, puerta, escalera, numero, calle, tipo, estado_inmueble, alturapor_planta, cuadrados_construidos, cuadrados_utiles, no_habitaciones, no_banos, estado, precio, precio_inmobiliaria, exterior_inte, no_garajes, no_ascensores, no_armarios, tipo_suelo, garaje_incluido, observacion, puerta_seguridad, alarma, cocinafull, aire_acondicionado,trastero, servicio_agua, calefaccion,antena,terraza, tendero,gastos_comunidad,pisicina, conserge, altura_edificio, antiguedad, puertaspor_planta, zonas_comunales,activo,DATE_FORMAT(fecha_alta,'%d-%m-%Y'),DATE_FORMAT(fecha_venta,'%d-%m-%Y'),DATE_FORMAT(fecha_baja,'%d-%m-%Y'),captador,vendedor,tipo_alquiler,precio_mes,precio_mes_publico,gastos_incluidos, referencia, planta, observacion_oculta, amueblado FROM $tabla WHERE Id='$id'";
		//echo $sql;
		$datos=Dosql::obtener_fila($sql);
		//echo $sql;
		return $datos;
	}	
	
	/*
	funcion Obtenersecciones
	entradas=
	salidas=Arreglo [id][seccion] de todas las secciones activas
	*/	
	function ObtenerPobla()
	{
		$tabla=$this->tabla_poblacion;
		//echo $sql;
		$sql="SELECT id,nombre FROM $tabla WHERE estado=1";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	
	function ObtenerTipo()
	{
		$tabla=$this->tabla_tipo;
		
		$sql="SELECT id,nombre FROM $tabla WHERE estado=1";
		//echo $sql;
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	
	function ObtenerTipoPorId($id)
	{
		$tabla=$this->tabla_tipo;
		
		$sql="SELECT id,nombre FROM $tabla WHERE estado=1 AND id='$id'";
		//echo $sql;
		$result=DoSQL::obtener_fila($sql);
        return $result;
	}
	
	function ObtenerDatosInmue2($id)
	{
		$tabla=$this->tabla_inmuebles;
		$sql="SELECT Id, Id_cliente, Poblacion, tipo, referencia, precio, activo, referencia FROM $tabla WHERE Id='$id'";
		$datos=Dosql::obtener_fila($sql);
		//echo $sql;
		return $datos;
	}	
	
	/*
	funcion ObtenerCliPorCampo
	entradas=cadena de busqueda,campo en que se debe buscar
	salidas=arreglo con is de todos los usuarios
	*/	
	function ObtenerInmuePorCampo($buscar,$campo)
	{
		$tabla=$this->tabla_inmuebles;
		$tabla1=$this->tabla_clientes;
		if ($campo=='nombre')
			$sql="SELECT $tabla.Id as Id FROM $tabla, $tabla1 WHERE ($campo LIKE '%$buscar%' Or apellidos LIKE '%$buscar%') AND $tabla.Id_cliente=$tabla1.Id";		
		else
			if ($campo=='tipo')
				$sql="SELECT $tabla.Id as Id FROM $tabla, inmueble_tipo WHERE (inmueble_tipo.nombre LIKE '%$buscar%') AND $tabla.tipo=inmueble_tipo.id";		
			else
				$sql="SELECT Id FROM $tabla WHERE $campo LIKE '%$buscar%'";
		//echo $sql;
		$id_usr2=Dosql::obtener_columna($sql);
		return $id_usr2;
	}	
	
	function ObtenerInmuePorCampo_fecha($buscar,$buscar2,$campo)
	{
		$tabla=$this->tabla_inmuebles;
		$tabla1=$this->tabla_clientes;
		if ($buscar2)
			$sql="SELECT Id FROM $tabla   where DATE_FORMAT($campo,'%d-%m-%Y') BETWEEN '$buscar' AND'$buscar2'";
		else
			$sql="SELECT Id FROM $tabla WHERE DATE_FORMAT($campo,'%d-%m-%Y') >= '$buscar'";
		//echo $sql;
		$id_usr2=Dosql::obtener_columna($sql);
		return $id_usr2;
	}
	
	function ObtenerInmuePorCampo_precio($buscar,$buscar2)
	{
		$tabla=$this->tabla_inmuebles;
		if ($buscar2)
			$sql="SELECT Id FROM $tabla WHERE precio >= $buscar AND precio <= $buscar2";
		else
			$sql="SELECT Id FROM $tabla WHERE precio >= $buscar";
		//echo $sql;
		$id_usr2=Dosql::obtener_columna($sql);
		return $id_usr2;
	}
	
	/*
	funcion ObtenerCliPorId
	entradas=id de usuario
	salidas=arreglo con información de la sección Id
	*/	
				
	function ObtenerInmuePorId()
	{
		$tabla=$this->tabla_inmuebles;
		$sql="SELECT Id FROM $tabla order by Id desc";
		$datos=Dosql::Obtener_columna($sql);
		
		return $datos;
	}	
	
	/*
	funcion EliminarSec
	entradas=id de usuario
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function EliminarInmue($id)
	{
		$tabla=$this->tabla_inmuebles;
		$tabla_imagenes=$this->tabla_inmobiliaria_imagenes;
		$sql="DELETE FROM $tabla_imagenes WHERE Id_inmueble='$id'";
		$datos=Dosql::query($sql);
		$sql="DELETE FROM $tabla WHERE Id='$id'";
		
		$datos=Dosql::query($sql);
		return $datos;
	}		
	
	/*
	funcion ActualizarDatosInmue
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function ActualizarDatosInmue($Id,$Id_cliente, $Poblacion, $orientacion, $codigopostal, $direccion, $puerta, $escalera, $numero, $calle, $tipo, $estado_inmueble, $alturapor_planta, $cuadrados_construidos, $cuadrados_utiles, $no_habitaciones, $no_banos, $estado, $precio, $precio_inmobiliaria, $exterior_inte, $no_garajes, $no_ascensores, $no_armarios, $tipo_suelo, $garaje_incluido, $observacion, $puerta_seguridad, $alarma, $cocinafull, $aire_acondicionado,$trastero, $servicio_agua, $calefaccion,$antena,$terraza, $tendero,$gastos_comunidad,$pisicina, $conserge, $altura_edificio, $antiguedad, $puertaspor_planta, $zonas_comunales, $activo,$captador,$vendedor,$tipo_alquiler,$precio_mes,$precio_mes_comision,$gastos_incluidos,$fecha_venta, $referencia, $planta, $fecha_baja, $fecha_alta,$observacion_oculta, $amueblado)
	{
		if ($conserge=='')
			$conserge=0;
		if ($numero=='')
			$numero=0;
		if ($cuadrados_construidos=='')
			$cuadrados_construidos=0;
		if ($cuadrados_utiles=='')
			$cuadrados_utiles=0;
		if ($no_habitaciones=='')
			$no_habitaciones=0;
		if ($puertaspor_planta=='')
			$puertaspor_planta=0;
		if ($altura_edificio=='')
			$altura_edificio=0;
		if ($alturapor_planta=='')
			$alturapor_planta=0;
		if ($activo=='')
			$activo=0;
		if ($fecha_venta=='')
			$fecha_venta='0000-00-00';
		if ($fecha_baja=='')
			$fecha_baja='0000-00-00';
		if ($fecha_alta=='')
			$fecha_alta='0000-00-00';
		if ($gastos_comunidad=='')
			$gastos_comunidad=0;
		if ($no_ascensores=='')
			$no_ascensores=0;
		if ($no_garajes=='')
			$no_garajes=0;
		if ($precio=='')
			$precio=0;
		if ($precio_mes=='')
			$precio_mes=0;
		if ($precio_mes_comision=='')
			$precio_mes_comision=0;
		if ($precio_inmobiliaria=='')
			$precio_inmobiliaria=0;
		if ($no_armarios=='')
			$no_armarios=0;
		
		$opcion_extra="";
		/*
		if ($activo==0)
		{
			$tabla=$this->tabla_inmuebles;
			$sql="SELECT * FROM $tabla WHERE activo=1 AND Id='$Id'";
			$datos=Dosql::obtener_cantidad($sql);
			if($datos==1)
			{
				$opcion_extra=", fecha_baja=NOW()";
			}
		}
		*/	
			
		$tabla=$this->tabla_inmuebles;
		
		if ($fecha_venta!='00-00-0000')
			$fecha_venta = strftime("%Y-%m-%d", strtotime($fecha_venta));
		if ($fecha_baja!='00-00-0000')
			$fecha_baja = strftime("%Y-%m-%d", strtotime($fecha_baja));
		if ($fecha_alta!='00-00-0000')
			$fecha_alta = strftime("%Y-%m-%d", strtotime($fecha_alta));
		
		
		$sql="UPDATE $tabla SET poblacion='$Poblacion',Id_cliente=$Id_cliente,orientacion='$orientacion', codigopostal='$codigopostal',Direccion='$direccion', puerta='$puerta',escalera='$escalera', referencia='$referencia',planta='$planta',calle='$calle',tipo=$tipo, estado_inmueble='$estado_inmueble', numero='$numero', alturapor_planta=$alturapor_planta, cuadrados_construidos=$cuadrados_construidos, cuadrados_utiles=$cuadrados_utiles, no_habitaciones=$no_habitaciones, no_banos=$no_banos, estado='$estado', precio=$precio, precio_inmobiliaria=$precio_inmobiliaria, exterior_inte=$exterior_inte, no_garajes=$no_garajes, no_ascensores=$no_ascensores, no_armarios=$no_armarios, tipo_Suelo='$tipo_suelo', garaje_incluido='$garaje_incluido', observacion='$observacion', puerta_seguridad='$puerta_seguridad', alarma='$alarma', cocinafull='$cocinafull', aire_acondicionado='$aire_acondicionado',trastero='$trastero', servicio_agua='$servicio_agua', calefaccion='$calefaccion',antena='$antena',terraza='$terraza', tendero='$tendero',gastos_comunidad=$gastos_comunidad,pisicina='$pisicina', conserge=$conserge, altura_edificio=$altura_edificio, antiguedad='$antiguedad', puertaspor_planta=$puertaspor_planta, zonas_comunales='$zonas_comunales', activo=$activo, captador='$captador',vendedor='$vendedor',tipo_alquiler=$tipo_alquiler,precio_mes=$precio_mes,precio_mes_publico=$precio_mes_comision,fecha_venta='$fecha_venta',fecha_alta='$fecha_alta',fecha_baja='$fecha_baja', amueblado=$amueblado, observacion_oculta='$observacion_oculta', gastos_incluidos='$gastos_incluidos'".$opcion_extra." WHERE Id='$Id'";
		
		//echo $sql;jkahjkshjkahshajkshjahksjas
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	
	/*
	funcion InsertarDatosInmue
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function InsertarDatosInmue($Id_cliente, $poblacion, $orientacion, $codigopostal, $direccion, $puerta, $escalera, $numero, $calle, $tipo, $estado_inmueble, $alturapor_planta, $cuadrados_construidos, $cuadrados_utiles, $no_habitaciones, $no_banos, $estado, $precio, $precio_inmobiliaria, $exterior_inte, $no_garajes, $no_ascensores, $no_armarios, $tipo_suelo, $garaje_incluido, $observacion, $puerta_seguridad, $alarma, $cocinafull, $aire_acondicionado,$trastero, $servicio_agua, $calefaccion,$antena,$terraza, $tendero,$gastos_comunidad,$pisicina, $conserge, $altura_edificio, $antiguedad, $puertaspor_planta, $zonas_comunales, $activo,$captador,$vendedor,$tipo_alquiler,$precio_mes,$precio_mes_comision,$gastos_incluidos,$fecha_venta, $referencia, $planta, $fecha_baja, $fecha_alta,$observacion_oculta, $amueblado)
	{
		if ($conserge=='')
			$conserge=0;
		if ($numero=='')
			$numero=0;
		if ($puerta=='')
			$puerta=0;
		if ($cuadrados_construidos=='')
			$cuadrados_construidos=0;
		if ($cuadrados_utiles=='')
			$cuadrados_utiles=0;
		if ($no_habitaciones=='')
			$no_habitaciones=0;
		if ($puertaspor_planta=='')
			$puertaspor_planta=0;
		if ($altura_edificio=='')
			$altura_edificio=0;
		if ($alturapor_planta=='')
			$alturapor_planta=0;
		if ($activo=='')
			$activo=0;
		if ($gastos_comunidad=='')
			$gastos_comunidad=0;
		if ($no_ascensores=='')
			$no_ascensores=0;
		if ($no_garajes=='')
			$no_garajes=0;
		if ($precio=='')
			$precio=0;
		if ($precio_inmobiliaria=='')
			$precio_inmobiliaria=0;
		if ($precio_mes=='')
			$precio_mes=0;
		if ($precio_mes_comision=='')
			$precio_mes_comision=0;
		if ($no_armarios=='')
			$no_armarios=0;
		if ($no_banos=='')
			$no_banos=0;
		if ($fecha_venta=='')
			$fecha_venta='0000-00-00';
		else
			$fecha_venta = strftime("%Y-%m-%d", strtotime($fecha_venta));
		if ($fecha_baja=='')
			$fecha_baja='0000-00-00';
		else
			$fecha_baja = strftime("%Y-%m-%d", strtotime($fecha_baja));
		if ($fecha_alta=='')
			$fecha_alta='0000-00-00';
		else
			$fecha_alta = strftime("%Y-%m-%d", strtotime($fecha_alta));
		
			
		$tabla=$this->tabla_inmuebles;
		
		$sql="INSERT INTO $tabla VALUES ('',$Id_cliente, '$direccion', '$codigopostal', '$poblacion', '$tipo', '$tipo_suelo', '$estado_inmueble', $exterior_inte, 0, $alturapor_planta, $altura_edificio, $no_habitaciones,0, $no_banos, $no_armarios, $no_ascensores, $no_garajes, $gastos_comunidad, '$calefaccion', '$servicio_agua', '$zonas_comunales',$puertaspor_planta,'$antiguedad','$puerta_seguridad', '$alarma', '$cocinafull','$trastero','$antena','$terraza', '$tendero' ,$conserge,'$orientacion', '$estado', $precio,'$pisicina', $precio_inmobiliaria,'$observacion','$puerta','$escalera','$calle',$numero,$cuadrados_construidos,$cuadrados_utiles, '$garaje_incluido', '$aire_acondicionado', $activo, '$fecha_alta', '$fecha_venta','$fecha_baja','$captador','$vendedor',$tipo_alquiler,$precio_mes,$precio_mes_comision,'$gastos_incluidos', '$referencia', '$planta', '$observacion_oculta', $amueblado )";
		//echo $sql;
		$datos=Dosql::query($sql);
		return $datos;
	}			
	
	
	
	/*
	funcion ObtenerUltimoId
	entradas=ninguno
	salidas=ultimo id registrado en la tabla de usuarios
	*/	
		
	function ObtenerUltimoId()
	{
		$tabla=$this->tabla_inmuebles;
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
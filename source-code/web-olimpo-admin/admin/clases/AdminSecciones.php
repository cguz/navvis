<?
class AdminSecciones{

	/*
	variables de configuracion de clase
	*/
	var $tabla_secciones = "pro_secciones";
	var $tabla_subsecciones_idioma = "pro_secciones_idioma";
	
	/*
	funcion Obtenersecciones
	entradas=
	salidas=Arreglo [id][seccion] de todas las secciones activas
	*/	
	function ObtenerSecciones($patern)
	{
		$tabla=$this->tabla_secciones;
		$sql="SELECT id,nombre,estado FROM $tabla WHERE patern='$patern' ORDER BY id";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	
	function ObtenerPadre($id){
		$tabla=$this->tabla_secciones;
		$sql="SELECT patern FROM  $tabla WHERE id=$id";
		$result=DoSQL::obtener_columna($sql);
		return $result;
	}
	/*
	funcion ObtenerDatosSec
	entradas=id de usuario
	salidas=arreglo con información de la sección Id
	*/	
				
	function ObtenerDatosSec($id)
	{
		$tabla_sec=$this->tabla_secciones;
		$sql="SELECT nombre,patern FROM $tabla_sec WHERE id='$id'";
		$datos=Dosql::obtener_fila($sql);
		return $datos;
	}
	
	/*
	funcion ObtenerDatosSecIn
	entradas=id de usuario
	salidas=arreglo con información en ingles de la sección Id
	*/	
		
	function ObtenerDatosSecIn($id)
	{
		$tabla_sec=$this->tabla_subsecciones_idioma;
		$sql="SELECT nombre FROM $tabla_sec WHERE id_seccion='$id'";
		$datos=Dosql::obtener_columna($sql);
		return $datos;
	}	
	
	/*
	funcion EliminarSec
	entradas=id de usuario
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function EliminarSec($id)
	{
		$tabla_sec=$this->tabla_secciones;
		$tabla_sec_idioma=$this->tabla_subsecciones_idioma;
		$sql="DELETE FROM $tabla_sec_idioma WHERE id_seccion='$id'";
		$datos=Dosql::query($sql);		
		$sql="DELETE FROM $tabla_sec WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}		
	/*
	funcion Obtenersecciones
	entradas=
	salidas=Arreglo [id][seccion] de todas las secciones activas
	*/	
	function ObtenerSecAdmin()
	{
		$tabla=$this->tabla_secciones;
		$sql="SELECT id,nombre FROM $tabla WHERE patern<='4' AND id>='1'";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	
	function obtenerDepartamentos(){
		$tabla=$this->tabla_departamentos;
	}
	
	/*
	funcion ActualizarDatosSec
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function ActualizarDatosSec($id,$nombre_es,$seccion)
	{
		$tabla=$this->tabla_secciones;
		$sql="UPDATE $tabla SET nombre='$nombre_es',patern='$seccion' WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	function ActualizarDatosSecIn($id,$nombre_in)
	{
		$tabla=$this->tabla_subsecciones_idioma;
		$sql="UPDATE $tabla SET nombre='$nombre_in' WHERE id_seccion='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}		
	
	/*
	funcion InsertarDatosSec
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function InsertarDatosSec($nombre_es,$seccion)
	{
		$tabla=$this->tabla_secciones;
		$sql="SELECT * FROM $tabla WHERE nombre='$nombre_es'";
		$datos=Dosql::obtener_cantidad($sql);
		if($datos==0)
		{
			$sql="INSERT INTO $tabla VALUES ('','$seccion','$nombre_es','','','1','','','','','')";
			$datos=Dosql::query($sql);
		}else{
			$datos="existe";
		}
		return $datos;
	}	
	
	function InsertarDatosSecIn($nombre_in)
	{
		$tabla=$this->tabla_secciones;
		$ultimo=Dosql::ObtenerUltimoReg($tabla,'id');
		$tabla_idioma=$this->tabla_subsecciones_idioma;
		$sql="INSERT INTO $tabla_idioma VALUES ('','$nombre_in','','','$ultimo[0]','')";
		$datos=Dosql::query($sql);
		return $datos;
	}		

	
	function ObtenerContenido($id)
	{
		$tabla=$this->tabla_secciones;
		$sql="SELECT contenido,nombre,imagen,planta, mostrar FROM $tabla WHERE id='$id'";
		$datos=DoSQL::obtener_fila($sql);
		return $datos;
	}	
	
	function ObtenerContenidoIn($id)
	{
		$tabla=$this->tabla_secciones;
		$tabla2=$this->tabla_subsecciones_idioma;
		$sql="SELECT ni.contenido,ni.nombre,ni.imagen, ni.planta, n.mostrar FROM $tabla as n,$tabla2 as ni WHERE n.id='$id' AND ni.id_seccion=n.id";
		$datos=DoSQL::obtener_fila($sql);
		return $datos;
	}	
	
	function GuardarContenido($id,$contenido,$imagen,$planta="",$mostrar="0")
	{
		$tabla=$this->tabla_secciones;
		if($imagen!='')
		{
			$sql="UPDATE $tabla SET contenido='$contenido',imagen='$imagen', planta='$planta', mostrar='$mostrar' WHERE id='$id'";
		}else{
			$sql="UPDATE $tabla SET contenido='$contenido', planta='$planta', mostrar='$mostrar' WHERE id='$id'";
		}
		$datos=Dosql::query($sql);
		return $datos;
	}	
	
	function GuardarContenidoIn($id,$contenido,$planta="",$mostrar=0)
	{
		
		$tabla=$this->tabla_subsecciones_idioma;
		$tabla2=$this->tabla_secciones;
		$sql="UPDATE $tabla2 SET mostrar='$mostrar' WHERE id='$id'";
		$datos=Dosql::query($sql);
		$sql="UPDATE $tabla SET contenido='$contenido', planta='$planta' WHERE id_seccion='$id'";
		$datos=Dosql::query($sql);
		return $datos;
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
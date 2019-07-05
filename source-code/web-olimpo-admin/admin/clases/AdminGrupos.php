<?
class AdminGrupos{
	
	/*
	variables de configuracion
	*/
	var $tabla_grp="pav_grupos";
	var $tabla_usr="pav_usuarios";
	var $tabla_grp_prv="pav_grupos_prv";	
	var $tabla_usr_grp="pav_usuarios_grp";
	
	/*
	funcion ObtenerGrpPorId
	entradas=ninguna
	salidas=arreglo con is de todos los usuarios
	*/	
	function ObtenerGrpPorId()
	{
		$tabla_grps=$this->tabla_grp;
		$sql="SELECT id,nombre FROM $tabla_grps";
		$id_grp=Dosql::obtener_filas($sql);
		return $id_grp;
	}		
	
	/*
	funcion VerificarPrivilegio verifica si el grupo tiene o no privilegio
	entradas=id de grupo,  privilegio
	salidas=true o false
	*/	
	function VerificarPrivilegio($id,$prv)	
	{
		$tabla_prvs=$this->tabla_grp_prv;
		$sql="SELECT * FROM $tabla_prvs WHERE id_grupo='$id' AND id_privilegio='$prv'";
		$prvs=Dosql::obtener_cantidad($sql);
		return $prvs;
	}

	/*
	funcion ObtenerDatosUsr
	entradas=id de usuario
	salidas=arreglo con información del usuario Id
	*/	
				
	function ObtenerDatosGrp($id)
	{
		$tabla_grps=$this->tabla_grp;
		$sql="SELECT nombre FROM $tabla_grps WHERE id='$id'";
		$datos=Dosql::obtener_columna($sql);
		return $datos;
	}	
	
	/*
	funcion ActualizarDatosGrp
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function ActualizarDatosGrp($id,$nombre)
	{
		$tabla_grps=$this->tabla_grp;
		$sql="UPDATE $tabla_grps SET nombre='$nombre' WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}	
	
	/*
	funcion InsertarDatosGrp
	entradas=id de grupo,nombre
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function InsertarDatosGrp($nombre)
	{
		$tabla_grps=$this->tabla_grp;
		$sql="SELECT * FROM $tabla_grps WHERE nombre='$nombre'";
		$datos=Dosql::obtener_cantidad($sql);
		if($datos==0)
		{
			$sql="INSERT INTO $tabla_grps VALUES ('','$nombre')";
			$datos=Dosql::query($sql);
		}else{
			$datos="existe";
		}
		return $datos;
	}	


	/*
	funcion guardarPrivilegio verifica si el grupo tiene o no privilegio
	entradas=id de usuario, privilegio,valor (si o no)
	salidas=true o false
	*/	
	function GuardarPrivilegio($id,$id_prv,$valor)
	{
		$existe=$this->VerificarPrivilegio($id,$id_prv);
		if($existe==1 && $valor=="no"){
			$this->BorrarPrivilegio($id,$id_prv);
		}else if($existe!=1 && $valor=="si"){
			$this->InsertarPrivilegio($id,$id_prv);
		}
		return;
	}	
	
	/*
	funcion InsertarPrivilegio
	entradas=id de grupo, privilegio
	salidas=true o false si se ejecuta o no la inserción
	*/	
	
	function InsertarPrivilegio($id,$id_prv)
	{
		$tabla_grps=$this->tabla_grp_prv;
		$sql="INSERT INTO $tabla_grps VALUES ('$id','$id_prv')";
		$datos=Dosql::query($sql);
		return;
	}

	/*
	funcion BorrarPrivilegio
	entradas=id de grupo, privilegio
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
	function BorrarPrivilegio($id,$id_prv)
	{
		$tabla_grps=$this->tabla_grp_prv;
		$sql="DELETE FROM $tabla_grps WHERE id_grupo='$id' AND id_privilegio='$id_prv'";
		$datos=Dosql::query($sql);
		return;
	}		

	/*
	funcion EliminarGrp
	entradas=id de usuario
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function EliminarGrp($id)
	{
		$tabla_grps=$this->tabla_grp;
		$sql="DELETE FROM $tabla_grps WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}	
	
	/*
	funcion ObtenerUltimaId
	entradas=ninguna
	salidas=Ultima id de grupo agregada
	*/	
	
	function ObtenerUltimaId()
	{
		$tabla_grps=$this->tabla_grp;
		$sql="SELECT id FROM $tabla_grps ORDER BY id DESC";
		$datos=Dosql::obtener_fila($sql);
		return $datos;
	}	
	
	/*
	funcion BorrarPrvGrp
	entradas=id de grupo
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
		
	function BorrarPrvGrp($id)
	{
		$tabla_grps=$this->tabla_grp_prv;
		$sql="DELETE FROM $tabla_grps WHERE id_grupo='$id'";
		$datos=Dosql::query($sql);
		return;
	}		

	/*
	funcion ObtenerUsrGrp
	entradas=id de grupo
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
		
	function ObtenerUsrGrp($id)	
	{
		$tabla_usr_grps=$this->tabla_usr_grp;
		$sql="SELECT * FROM $tabla_usr_grps WHERE id_grupo='$id'";
		$result=Dosql::obtener_columna($sql);
		return $result;	
	}
	
}
?>
<?
class AdminUsuarios{
	/*
	variables de configuracion
	*/
	var $tabla_usr_prv="pav_usuarios_prv";
	var $tabla_usr="pav_usuarios";
	var $tabla_prv="pav_privilegios";
	var $tabla_usr_grp="pav_usuarios_grp";

	/*
	funcion ValidarEntrada
	entradas=nombre de usuario,contraseña
	salidas=retorna id usuario 
	*/	
	function  ValidarEntrada($usr,$pass)
	{
		$tabla_prvs=$this->tabla_usr;
		$pass=md5($pass);
		$sql="SELECT id FROM $tabla_prvs WHERE nick='$usr' AND password='$pass'";
		$prvs=Dosql::obtener_columna($sql);
		return $prvs[0];
	}
	
	/*
	funcion ObtenerPrivilegios de un usuario
	entradas=id de usuario
	salidas=arreglo con el id de cada uno de los privilegios
	*/	
	function ObtenerPrivilegios($id_usr)
	{
		$tabla_prvs=$this->tabla_usr_prv;
		$sql="SELECT id_privilegio FROM $tabla_prvs WHERE id_usuario='$id_usr' ORDER BY id_privilegio ASC";
		//echo $sql;
		$prvs=Dosql::obtener_columna($sql);
		return $prvs;
	}
	
	/*
	funcion Obtener Nombre de todos los Privilegios Padre
	entradas=id de usuario
	salidas=arreglo con el id de cada uno de los privilegios
	*/	
	function ObtenerNomPrv($patern)
	{
		$tabla_prvs=$this->tabla_prv;
		$sql="SELECT prv_id,prv_nombre FROM $tabla_prvs WHERE prv_patern='$patern'";
		$prvs=Dosql::obtener_filas($sql);
		return $prvs;
	}	
	
	/*
	funcion VerificarPrivilegio verifica si el usuario tiene o no privilegio
	entradas=id de usuario,  privilegio
	salidas=true o false
	*/	
	function VerificarPrivilegio($id,$prv)	
	{
		$tabla_prvs=$this->tabla_usr_prv;
		$sql="SELECT * FROM $tabla_prvs WHERE id_usuario='$id' AND id_privilegio='$prv'";
		$prvs=Dosql::obtener_cantidad($sql);
		return $prvs;
	}	
	
	/*
	funcion GuardarPrivilegio verifica si el usuario tiene o no privilegio
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
	funcion ObtenerVarPrv
	entradas=id de usuario
	salidas=arreglo con el id de cada uno de los privilegios
	*/	
	
	function ObtenerVarPrv($id_prv)
	{
		$tabla_prvs=$this->tabla_prv;
		$sql="SELECT prv_var FROM $tabla_prvs WHERE prv_id='$id_prv'";
		$prvs=Dosql::obtener_columna($sql);
		return $prvs[0];
	}	
	
	/*
	funcion ObtenerPrivilegios
	entradas=id de usuario
	salidas=arreglo con el id de cada uno de los privilegios
	*/	
	function ObtenerPrvPorId($id_prv)
	{
		$tabla_prvs=$this->tabla_prv;
		$sql="SELECT prv_nombre FROM $tabla_prvs WHERE prv_id='$id_prv' ORDER BY prv_id asc";
		$nombre=Dosql::obtener_columna($sql);
		return $nombre;
	}	
	
	/*
	funcion ObtenerUsrPorId
	entradas=ninguna
	salidas=arreglo con is de todos los usuarios
	*/	
	function ObtenerUsrPorId()
	{
		$tabla_usrs=$this->tabla_usr;
		$sql="SELECT id FROM $tabla_usrs";
		$id_usr=Dosql::obtener_columna($sql);
		return $id_usr;
	}	
	
	/*
	funcion ObtenerUsrPorCampo
	entradas=cadena de busqueda,campo en que se debe buscar
	salidas=arreglo con is de todos los usuarios
	*/	
	function ObtenerUsrPorCampo($buscar,$campo)
	{
		$tabla_usrs=$this->tabla_usr;
		$sql="SELECT id FROM $tabla_usrs WHERE $campo LIKE '%$buscar%'";
		$id_usr=Dosql::obtener_columna($sql);
		return $id_usr;
	}				
	
	/*
	funcion ObtenerDatosUsr
	entradas=id de usuario
	salidas=arreglo con información del usuario Id
	*/	
	function ObtenerDatosUsr($id)
	{
		$tabla_usrs=$this->tabla_usr;
		$sql="SELECT id,nombre,apellido,nick,email FROM $tabla_usrs WHERE id='$id'";
		$datos=Dosql::obtener_fila($sql);
		return $datos;
	}		

	/*
	funcion ActualizarDatosUsr
	entradas=id de usuario,nombre,apellido,nick,correo,grupo
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function ActualizarDatosUsr($id,$nombre,$apellido,$nick,$correo,$grupo)
	{
		$tabla_usrs=$this->tabla_usr;
		$tabla_grp_usr=$this->tabla_usr_grp;
		$sql="UPDATE $tabla_grp_usr SET id_grupo='$grupo' WHERE id_usuario='$id'";
		$datos=Dosql::query($sql);	
		$sql="UPDATE $tabla_usrs SET nombre='$nombre',apellido='$apellido',nick='$nick',email='$correo' WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}	
	
	function CambiarCarpGrp($id_usuario,$nuevo_grupo){
		$sql="SELECT id_grupo FROM $this->tabla_usr_grp WHERE id_usuario=$id_usuario";
		$res=DoSQL::Obtener_Columna($sql);
		if($res[0]!=$nuevo_grupo)
		{		
			$sql="DELETE FROM pav_carpetas_usuario WHERE id_usuario='$id_usuario'";
			DoSQL::query($sql);
			$sql="SELECT id_carpeta FROM pav_carpetas_grupo WHERE id_grupo='$nuevo_grupo'";
			$res=DoSQL::Obtener_Columna($sql);
			$i=0;
			while($res[$i]){
				$sql="INSERT INTO pav_carpetas_usuario (id, id_usuario, id_carpeta)
						VALUES('','$id_usuario','".$res[$i]."')";
				DoSQL::query($sql);
				$i++;
			}
		}	
	}
	
	/*
	funcion InsertarDatosUsr
	entradas=id de usuario,nombre,apellido,nick,correo,password,grupo
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function InsertarDatosUsr($id,$nombre,$apellido,$nick,$correo,$password,$grupo)
	{
		$tabla_usrs=$this->tabla_usr;
		$tabla_grp_usr=$this->tabla_usr_grp;		
		$password=md5($password);
		$sql="SELECT * FROM $tabla_usrs WHERE nick='$nick'";
		$datos=Dosql::obtener_cantidad($sql);
		if($datos==0)
		{
			$sql="INSERT INTO $tabla_usrs VALUES ('','$nombre','$apellido','$nick','$password','$correo')";
			$datos=Dosql::query($sql);
			$id=Dosql::ObtenerUltimoReg($tabla_usrs,'id');
			$sql="INSERT INTO $tabla_grp_usr VALUES ('$id[0]','$grupo')";
			$datos=Dosql::query($sql);			
		}else{
			$datos="existe";
		}
		return $datos;
	}	
	
	/*
	funcion CambiarPassUsr
	entradas=id de usuario,password
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function CambiarPassUsr($id,$password)
	{
		$tabla_usrs=$this->tabla_usr;
		$password=md5($password);
		$sql="UPDATE $tabla_usrs SET password='$password' WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}		

	/*
	funcion EliminarUsr
	entradas=id de usuario
	salidas=true si se efectuo la actualizacion o de lo contrario false
	*/	
	
	function EliminarUsr($id)
	{
		$tabla_usrs=$this->tabla_usr;
		$sql="DELETE FROM $tabla_usrs WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}	
	
	/*
	funcion InsertarPrivilegio
	entradas=id de usuario, privilegio
	salidas=true o false si se ejecuta o no la inserción
	*/	
	
	function InsertarPrivilegio($id,$id_prv)
	{
		$tabla_prvs=$this->tabla_usr_prv;
		$sql="INSERT INTO $tabla_prvs VALUES ('$id','$id_prv')";
		$datos=Dosql::query($sql);
		return;
	}

	/*
	funcion BorrarPrivilegio
	entradas=id de usuario, privilegio
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
	function BorrarPrivilegio($id,$id_prv)
	{
		$tabla_prvs=$this->tabla_usr_prv;
		$sql="DELETE FROM $tabla_prvs WHERE id_usuario='$id' AND id_privilegio='$id_prv'";
		$datos=Dosql::query($sql);
		return;
	}
	
	/*
	funcion BorrarPrvUsr
	entradas=id de usuario
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
		
	function BorrarPrvUsr($id)
	{
		$tabla_prvs=$this->tabla_usr_prv;
		$sql="DELETE FROM $tabla_prvs WHERE id_usuario='$id'";
		$datos=Dosql::query($sql);
		return;
	}	
	
	/*
	funcion BorrarUsrGrp
	entradas=id de usuario
	salidas=true o false si se ejecuta o no la eliminación del registro
	*/	
		
	function BorrarUsrGrp($id)
	{
		$tabla_prvs=$this->tabla_usr_grp;
		$sql="DELETE FROM $tabla_prvs WHERE id_usuario='$id'";
		$datos=Dosql::query($sql);
		return;
	}	
	
	/*
	Funcion para corrar las carpetas que un usuario tiene asignadas una vez el usuario es eliminado	
	*/
	
	function BorrarCarpUsr($id){
		$sql="DELETE FROM pav_carpetas_usuario WHERE id_usuario=$id";
		DoSQL::query($sql);
		return;
	}
	
	/*
	funcion ObtenerGrpUsr
	entradas=id de usuario
	salidas=id del grupo al cual pertence el usuario
	*/		
	
	function ObtenerGrpUsr($id_usr)	
	{
		$tabla_usr_grps=$this->tabla_usr_grp;
		$sql="SELECT * FROM $tabla_usr_grps WHERE id_usuario='$id_usr'";
		$result=Dosql::obtener_fila($sql);
		return $result;	
	}

	/*
	funcion ObtenerUltimoId
	entradas=ninguno
	salidas=ultimo id registrado en la tabla de usuarios
	*/	
		
	function ObtenerUltimoId()
	{
		$tabla_usrs=$this->tabla_usr;
		$datos=Dosql::ObtenerUltimoReg($tabla_usrs,'id');
		return $datos[0];
	}				
}
?>
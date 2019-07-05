<?

class AdminCorreos{
	
	var $tabla_correos="pro_correos";
	
	function ObtenerCorreos(){
		$tabla=$this->tabla_correos;
		$sql="SELECT * FROM  $tabla";
		$res = DoSQL::Obtener_Filas($sql);
		return $res;
	}
	
	function tomarIDs(){
		$tabla=$this->tabla_correos;
		$sql="SELECT id FROM $tabla";
		$res=DoSQL::Obtener_Columna($sql);
		return $res;
	}
	
	function actualizarCorreo($id, $nom_es, $nom_in, $correo){
		$tabla=$this->tabla_correos;
		$sql="UPDATE $tabla SET departamento_es='$nom_es', departamento_en='$nom_in', correo='$correo'
			  WHERE id='$id'";
		DoSQL::query($sql);
		return;
	}
	
	function eliminarCorreo($id){
		$tabla=$this->tabla_correos;
		$sql="DELETE FROM $tabla WHERE id='$id'";
		
		DoSQL::query($sql);
		return;
	}
	
	function crearCorreo($nom_es, $nom_in, $correo){
		$tabla=$this->tabla_correos;
		$sql="INSERT INTO $tabla (id, departamento_es, departamento_en, correo)
			  VALUES ('','$nom_es','$nom_in','$correo')";
		$ind=DoSQL::query($sql);
		return $ind;
	}
}

?>
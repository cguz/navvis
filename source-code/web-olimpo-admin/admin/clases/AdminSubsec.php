<?
class AdminSubsec{
	
	function getSecciones($campos, $condicion){
		$sql="SELECT $campos FROM pro_secciones WHERE $condicion";
		$res=DoSQL::obtener_Filas($sql);
		return $res;
	}
	
	function getSubcategorias($padre){
		$sql="SELECT * FROM pro_secciones WHERE patern='$padre' ORDER BY id";
		$res=DoSQL::obtener_Filas($sql);
		return $res;
	}
	
	function getInfo($id,$campos,$idioma){
		if($idioma=="in")
			$sql="SELECT $campos FROM pro_secciones_idioma WHERE id_seccion=$id";
		else
			$sql="SELECT $campos FROM pro_secciones WHERE id=$id";
		$res=DoSQL::Obtener_fila($sql);
		return $res;	
	}
	
	function actualizarDatos($tabla,$id,$titulo,$contenido,$imagen){
		if($imagen!="")
			$add=", imagen='$imagen'";
		if($tabla=="pro_secciones_idioma")
			$campo="id_seccion";
		else
			$campo="id";
		$sql="UPDATE $tabla SET nombre='$titulo', contenido='$contenido'$add 
			  WHERE $campo='$id'";
		DoSQL::query($sql);
	}
	
	function getPosicion($id){
		$sql="SELECT patern FROM pro_secciones WHERE id='$id'";
		$res=DoSQL::Obtener_Columna($sql);
		$sql="SELECT id FROM pro_secciones
			  WHERE patern='".$res[0]."' Order by id";
		$res=DoSQL::Obtener_Columna($sql);
		$pos=-1;
		for($k=0;$k<count($res);$k++){
			if($res[$k]==$id){
				$pos=$k;
				break;
			}
		}
		return $pos;
	}

	function eliminarSeccion($id){
		
		//Falta eliminar los productos de esta sección
		
		$msg="Se elimin&oacute; la secci&oacute;n con éxito";
		$sql="DELETE FROM pro_secciones WHERE id='$id'";
		if(!DoSQL::query($sql)){
			$msg="Ha ocurrido un error al eliminar la Secci&nbsp;n";
		}
		$sql="DELETE FROM pro_secciones_idioma WHERE id_seccion='$id'";
		if(!DoSQL::query($sql)){
			$msg="Ha ocurrido un error al eliminar la Secci&nbsp;n";
		}
		return $msg;
	}
	
	function addSecciones($titulo,$contenido,$imagen, $categoria){
		$fecha= date("Y-m-d hh:mm_ss");
		$msg="Se creo la nueva secci&oacute;n";
		$sql="INSERT INTO pro_secciones (id,patern,nombre,contenido,imagen,estado,posicion,fecha,usuario)
			  VALUES ('','$categoria','$titulo','$contenido','$imagen','1','0','$fecha','$id_intranet')";
		DoSQL::query($sql);
		$sql="SELECT MAX(id) as id FROM pro_secciones";	
		$res=DoSQL::Obtener_columna($sql);
		$sql="INSERT INTO pro_secciones_idioma (id,nombre,contenido,id_seccion)
			  VALUES ('','$titulo','$contenido','".$res[0]."')";
		DoSQL::query($sql);
		return $msg;
	}
	
	function subirArchivo($archivo,$validos,$ruta, $ancho="", $alto=""){
		
		list($an,$al,$tipo,$atr)=getimagesize($archivo["tmp_name"]);
		if($ancho!="")
		{
			$aux=abs($ancho-$an);//Resto los dos anchos
			if($aux<5)
				$ind_an=1;
			else
				$ind_an=0;
		}
		else
			$ind_an=1;
		if($alto!="")
		{
			$aux=abs($alto-$al);//Resto los dos altos
			if($aux<5)
				$ind_al=1;
			else
				$ind_al=0;
		}
		else
			$ind_al=1;
		if($ind_an && $ind_al){
			if(in_array($archivo["type"],$validos))//Si la extension del archivo esta en los archivos válidos
			{
				$ext=substr($archivo["name"],-3);
				if(@move_uploaded_file($archivo['tmp_name'], $ruta.".".$ext))
				{
					$ind=1;				
				}else
					$ind=0;
			}else{
				$ind=0;
			}
		}
		else
			$ind=0;	
		return $ind;
	}
	
	function getUltimaPos($cat){
		$sql="SELECT count(id) FROM pro_secciones
			  WHERE patern='$cat' Order by id";
		$res=DoSQL::Obtener_Columna($sql);
		return $res[0];
	}
	
	function generar_xml($subcat,$idioma){
		if($idioma=="es"){
			$ruta="../secciones/p$subcat/subsecciones.xml";
		}
		else{
			$ruta="../secciones/p$subcat/subsecciones_en.xml";
		}
		$res=$this->getSubcategorias($subcat);
		$archivo=fopen($ruta,"w+");
		fwrite($archivo,utf8_encode("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<bjork>\n"));
		$j=0;
		foreach($res as $fila){
			$datos=$this->getInfo($fila[0],"nombre,contenido",$idioma);
			$imprimir="<g$j titulo='".strtoupper($datos[0])."'>".$datos[1]."</g$j>\n";
			fwrite($archivo,utf8_encode(str_replace("\n","",$imprimir)));
			$j++;
		}
		fwrite($archivo,utf8_encode("</bjork>"));
		fclose($archivo);
	}
}
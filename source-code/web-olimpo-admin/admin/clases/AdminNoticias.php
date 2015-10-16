<?
class AdminNoticias{
	
	/*
	variables de configuracion de clase
	*/
	var $tabla_noticias = "pro_noticias";
	var $tabla_banners = "pro_banners";
	var $tabla_banners_idioma = "pro_banners_idioma";
	var $tabla_noticias_idioma = "pro_noticias_idioma";
	/*
	funcion Obtenerresumen
	entradas=cantidad de noticias para mostrar,resaltada=1 o no resaltada=0
	salidas=Arreglo [id][titulo][resumen] de cantidad de noticias seleccionadas
	*/		
	function Obtenerresumen($cantidad,$resaltada)
	{
		if($resaltada==0)
		{
			$campos="id,titulo,resumen";
		}else{
			$campos="imagen,id,titulo,resumen";
		}
		$tabla=$this->tabla_noticias;
		$sql="SELECT $campos FROM $tabla WHERE resaltada='$resaltada' AND estado='1' ORDER BY posicion asc LIMIT 0,$cantidad";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}
	/*
	funcion Obtenerresumen_idioma
	entradas=cantidad de noticias para mostrar,resaltada=1 o no resaltada=0
	salidas=Arreglo [id][titulo][resumen] de cantidad de noticias seleccionadas en tabla de idioma
	*/		
	function Obtenerresumen_idioma($cantidad,$resaltada)
	{
		if($resaltada==0)
		{
			$campos="ni.id_noti,ni.titulo,ni.resumen";
		}else{
			$campos="n.imagen,ni.id_noti,ni.titulo,ni.resumen";
		}
		$tabla1=$this->tabla_noticias;
		$tabla2=$this->tabla_noticias_idioma;
		$sql="SELECT $campos FROM $tabla2 as ni,$tabla1 as n WHERE n.resaltada='$resaltada' AND n.estado='1' AND ni.id_noti=n.id 
			  ORDER BY posicion asc LIMIT 0,$cantidad";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}

	/*
	funcion ObtenernoticiaporId
	entradas=id de la noticia
	salidas=Arreglo [titulo][contenido] de la noticia [id]
	*/	
	function ObtenernoticiaporId($id)
	{
		$tabla=$this->tabla_noticias;
		$sql="SELECT titulo,contenido,resumen,imagen,resaltada,estado FROM $tabla WHERE estado='1' AND id='$id'";
 		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}
	
	/*
	funcion ObtenernoticiaporId_idioma
	entradas=id de la noticia
	salidas=Arreglo [titulo][contenido] de la noticia [id] en la tabla de idioma
	*/	
	
	function ObtenernoticiaporId_idioma($id)
	{
		$tabla1=$this->tabla_noticias;
		$tabla2=$this->tabla_noticias_idioma;
		$sql="SELECT ni.titulo,ni.contenido,ni.resumen,n.imagen,n.resaltada,n.estado FROM $tabla2 as ni,$tabla1 as n WHERE n.estado='1' AND n.id=ni.id_noti AND ni.id_noti='$id'";
		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}
	
	/*
	funcion Obtenertitulos
	entradas=id de la noticia actual
	salidas=Arreglo [id][titulo] de todas las noticia activas excepto [id]
	*/	
	
	function Obtenertitulos($id)
	{
		$tabla1=$this->tabla_noticias;
		$sql="SELECT id,titulo FROM $tabla1 WHERE estado='1' AND id!='$id'";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}		

	/*
	funcion Obtenertitulos
	entradas=id de la noticia actual
	salidas=Arreglo [id][titulo] de todas las noticia activas excepto [id] en la tabla de idioma
	*/	
	
	function Obtenertitulos_idioma($id)
	{
		$tabla1=$this->tabla_noticias;
		$tabla2=$this->tabla_noticias_idioma;
		$sql="SELECT n.id,ni.titulo FROM $tabla2 as ni,$tabla1 as n WHERE n.estado='1' AND n.id=ni.id_noti AND ni.id_noti!='$id'";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}	

	/*
	funcion ObtenerInfoNotis
	entradas=
	salidas=Arreglo [id][titulo] de todas las noticias
	*/
	function ObtenerInfoNotis()
	{
		$tabla=$this->tabla_noticias;
		$sql="SELECT id,titulo,estado,resaltada,fecha,usuario,posicion FROM $tabla ORDER BY  resaltada,posicion ASC";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}	
		
	function OrdernarNoticias($posicion,$campo)
	{
		$tabla=$this->tabla_noticias;
 	    $sql="update $tabla set posicion='$posicion' where id='$campo'";
        $result=Dosql::query($sql);
		return $result;
	}	

	function ObtenerInfoporId($id)
	{
		$tabla=$this->tabla_noticias;
		$sql="SELECT titulo,contenido,resumen,imagen,resaltada,estado FROM $tabla WHERE id='$id'";
 		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}
	
	function ObtenerInfoporId_idioma($id)
	{
		$tabla=$this->tabla_noticias;
		$tabla2=$this->tabla_noticias_idioma;
		$sql="SELECT ni.titulo,ni.contenido,ni.resumen,n.imagen,n.resaltada,n.estado FROM $tabla2 as ni,$tabla as n WHERE n.id=ni.id_noti AND ni.id_noti='$id'";
 		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}	
	
	function EliminarNoti($id)
	{
		$tabla_noti=$this->tabla_noticias;
		$sql="DELETE FROM $tabla_noti WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	function EliminarNotiIn($id)
	{
		$tabla_noti=$this->tabla_noticias_idioma;
		$sql="DELETE FROM $tabla_noti WHERE id_noti='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	function GuardarContenido($id,$titulo,$resumen,$contenido,$imagen,$resaltada,$estado,$user)
	{
		$tabla_noti=$this->tabla_noticias;
		$sql="UPDATE $tabla_noti 
			  SET titulo='$titulo',resumen='$resumen',contenido='$contenido',imagen='$imagen',resaltada='$resaltada',estado='$estado',usuario='$user' 
			  WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	function GuardarContenido_idioma($id,$titulo,$resumen,$contenido,$imagen,$resaltada,$estado,$user)
	{
		$tabla_noti=$this->tabla_noticias;
		$tabla_noti_idioma=$this->tabla_noticias_idioma;
		$sql="UPDATE $tabla_noti 
			  SET imagen='$imagen',resaltada='$resaltada',estado='$estado',usuario='$user' WHERE id='$id'";
		$datos=Dosql::query($sql);
		$sql="UPDATE $tabla_noti_idioma SET titulo='$titulo',resumen='$resumen',contenido='$contenido' WHERE id_noti='$id'";
		$datos=Dosql::query($sql);		
		return $datos;
	}	
	
	function InsertarContenido($titulo,$resumen,$contenido,$imagen,$resaltada,$estado,$user)
	{
		$tabla_noti=$this->tabla_noticias;
		$tabla_noti_idioma=$this->tabla_noticias_idioma;
		$fecha=date('Y-m-d');
		$sql="INSERT INTO $tabla_noti VALUES ('','$titulo','$resumen','$contenido','$imagen','$fecha','0','0','$resaltada','$estado','$user')";
		$datos=Dosql::query($sql);
		$sql="SELECT id FROM $tabla_noti ORDER BY id DESC";
		$row=DoSQL::Obtener_fila($sql);
		$sql="INSERT INTO $tabla_noti_idioma VALUES ('','','','','$row[0]')";
		$datos=Dosql::query($sql);		
		return $datos;
	}	
	
	function OrdernarBanners($posicion,$campo)
	{
		$tabla=$this->tabla_banners ;
 	    $sql="update $tabla set posicion='$posicion' where id='$campo'";
        $result=Dosql::query($sql);
		return $result;
	}		
	
	function ObtenerInfoBanners()
	{
		$tabla=$this->tabla_banners;
		$sql="SELECT id,nombre,estado,tipo,fecha,usuario,posicion FROM $tabla ORDER BY posicion ASC";
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}	

	/*
	funcion Obtenerbanners
	entradas=cantidad de banners para mostrar
	salidas=Arreglo [banner][tipo] de cantidad de banners seleccionadas
	*/	
		
	function Obtenerbanners($cantidad)
	{
		$tabla_banners=$this->tabla_banners;
		$sql="SELECT contenido,tipo FROM $tabla_banners WHERE estado='1' ORDER BY posicion asc LIMIT 0,$cantidad";
 		$resultado= mysql_query($sql);
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}	
	
	function Obtenerbanners_idioma($cantidad)
	{
		$tabla_banners=$this->tabla_banners;
		$tabla_banners2=$this->tabla_banners_idioma;
		$sql="SELECT bi.contenido,b.tipo FROM $tabla_banners as b,$tabla_banners2 as bi WHERE b.estado='1' AND bi.ban_id=b.id ORDER BY b.posicion asc LIMIT 0,$cantidad";
		$resultado= mysql_query($sql);
		$result=DoSQL::obtener_filas($sql);
        return $result;
	}		
	
	function ObtenerBannerporId($id)
	{
		$tabla=$this->tabla_banners;
		$sql="SELECT nombre,contenido,estado,tipo FROM $tabla WHERE id='$id'";
 		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}	
	
	function ObtenerBannerporId_idioma($id)
	{
		$tabla=$this->tabla_banners;
		$tabla2=$this->tabla_banners_idioma;
		$sql="SELECT b.nombre,bi.contenido,b.estado,b.tipo FROM $tabla as b,$tabla2 as bi WHERE b.id=$id AND bi.ban_id=b.id";
 		$row=DoSQL::Obtener_fila($sql);
        return $row;
	}		
	
	function InsertarBanner($nombre,$contenido,$estado,$tipo,$usr_nombre)	
	{
		$tabla=$this->tabla_banners;
		$tabla2=$this->tabla_banners_idioma;
		$fecha=date('Y-m-d');
		$sql="INSERT INTO $tabla VALUES ('','$nombre','$contenido','0','$estado','$tipo','$fecha','$usr_nombre')";
		$result=Dosql::query($sql);
		$sql="SELECT id FROM $tabla ORDER BY id DESC";
		$row=DoSQL::Obtener_fila($sql);
		$sql="INSERT INTO $tabla2 VALUES ('','','$row[0]')";
		$result=Dosql::query($sql);		
		return $result;
	}
	
	function GuardarBanner($id,$nombre,$contenido,$estado,$tipo,$usr_nombre)	
	{
		$tabla=$this->tabla_banners;
		$fecha=date('Y-m-d h:i:s');
		$sql="UPDATE $tabla 
			  SET nombre='$nombre',contenido='$contenido',estado='$estado',tipo='$tipo',fecha='$fecha',usuario='$usr_nombre'
			  WHERE id='$id'";
		$result=Dosql::query($sql);
		return $result;
	}	
	
	function GuardarBanner_idioma($id,$nombre,$contenido,$estado,$tipo,$usr_nombre)	
	{
		$tabla=$this->tabla_banners;
		$tabla2=$this->tabla_banners_idioma;
		$fecha=date('Y-m-d h:i:s');
		$sql="UPDATE $tabla 
			  SET nombre='$nombre',estado='$estado',tipo='$tipo',fecha='$fecha',usuario='$usr_nombre'
			  WHERE id='$id'";
		$result=Dosql::query($sql);
		$sql="UPDATE $tabla2 
			  SET contenido='$contenido' WHERE ban_id='$id'";
		$result=Dosql::query($sql);
		return $result;
	}		
	function EliminarBanner($id)
	{
		$tabla=$this->tabla_banners;
		$sql="DELETE FROM $tabla WHERE id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}
	
	function EliminarBannerIn($id)
	{
		$tabla=$this->tabla_banners_idioma;
		$sql="DELETE FROM $tabla WHERE ban_id='$id'";
		$datos=Dosql::query($sql);
		return $datos;
	}	
}
?>
<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	
	$campo_where = "";
	if($_SESSION['TipoUsuario'] != 'A'){
		$campo_where .= " AND proyectos.IdUsuario = $_SESSION[id_usuario_actual]";
	}

	$ITEMS_CONSULTAS = 5;		
	if(isset($_GET[ban]) && ($_GET[ban]=="get")){
		$cadena=base64_decode($_GET[cadena]);		
		$primero = $_GET[primero];	
		
	}else{
		$cadena=$_POST[cadena];
		$primero = $_POST[primero];	
	}	
	
	if(isset($_GET[eliminar]) && ($_GET[eliminar]=="SI")){	
		$query=<<<QUERY
			UPDATE proyectos SET EstadoProyecto = 'I'
			WHERE IdProyecto = $_GET[IdProyecto] 
			$campo_where
QUERY;
			$res=actualizar($query);
			if($res==false){
				$cadena=base64_encode($cadena);
				mensajes_advertencia("Error al actualizar Proyecto.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
			}
			$mensaje_error = "Eliminado proyecto con &eacute;xito.";
	}
	//$cadena = caracteres_filtros($cadena);
	$cadena = trim($cadena);	
	if (strlen($cadena)> 0)
		$campo_where .=" AND NombreProyecto LIKE '%$cadena%'";	
		
		
	if (strlen($primero) == 0){$primero=0;}
	$ultimo = $ITEMS_CONSULTAS + 1;
	
	$query =<<<QUERY
	SELECT *, proyectos.Enlace as EnlaceP FROM proyectos, concursos 
	WHERE proyectos.IdConcurso = concursos.IdConcurso
	AND EstadoProyecto = 'A' $campo_where	
	ORDER BY IdProyecto DESC
	LIMIT $primero,$ultimo
QUERY;
	$res_p=consultar($query);
	
	/*if(!is_array($res_p)){
		mensajes_advertencia ("No hay informaci&oacute;n que mostrar.","principal.php");
	}*/
	$cadena = quitar_caracteres_filtros($cadena);
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<form name="form1" method="post" action="editar_eliminar_proyectos.php">
<div id="navegacion2"><a href="principal.php">inicio</a> > actualizar proyectos</div>






<!--Codigo para el buscador -->
	<div id="buscador">
    <div class="boton_nuevo"><a href="nuevo_proyecto_1.php" target="_top">Nuevo Proyecto</a></div> 
		<div class="titulo_cuadro"><span id="noresaltado">Buscar proyecto</span></div>
		<table width="0%" border="0" cellspacing="5" cellpadding="2">
		  <tr>
			<td><input name="cadena" type="text" size="20" maxlength="80" value="<?php echo $cadena; ?>"></td>
		  </tr>
			<tr>
			<td><div align="center">
			  <input type="submit" name="Submit" value="Buscar">
			  </div></td>
		  </tr>
          <tr>
          <td>
          
          </td>
          </tr>
		</table>
	</div>
 <!--Codigo para el buscador -->  

<div id="parrafoprincipal">  
       
<?php	
		$cont = 0;
		$total_items = count($res_p);
		$cadena2=base64_encode($cadena);		
		while(is_array($res_p) && (list($Id,$Dato)=each($res_p)) && ($cont < $ultimo - 1)){ 
			$cont ++;
			$NombreProyecto = quitar_caracteres_filtros($Dato[NombreProyecto]);
			$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
			$Enlace = "http://".quitar_caracteres_filtros($Dato[EnlaceP]);
			$Descripcion = substr(stripslashes($Dato[Texto]),0,100);
			$query=<<<QUERY
			SELECT * FROM adjuntosproyectos WHERE IdProyecto = $Dato[IdProyecto]
			AND EstadoAdjunto = 'A'
			LIMIT 1
QUERY;
			$res=consultar($query);
			$adjunto = "&nbsp;";
			if(is_array($res) && count($res)>0){
				$adjunto = "documento adjunto&nbsp;<img src=\"iconos/paperclip.gif\" alt=\"Archivos Adjuntos\">";
			}
?>
<div class="listaproyectos">
	  <table width="400px" cellpadding="5" cellspacing="5">
        <tr>
          <td width="100px" align="right" valign="top"><div align="right"><a href="detalles_proyecto.php?IdProyecto=<?php echo $Dato[IdProyecto]; ?>" target="_top"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Dato[Imagen]; ?>" width="100"></a></div></td>
          <td colspan="2" align="left" valign="top">
		  <table width="285px"  border="0">
          
            <tr>
              <td width="24%" align="right" valign="top"><div align="left"><span id="noresaltado">Nombre:</span></div></td>
              <td width="76%" align="left" valign="top"><div align="left"><a href="detalles_proyecto.php?IdProyecto=<?php echo $Dato[IdProyecto]; ?>" target="_top"><?php echo $NombreProyecto; ?></a></div></td>
            </tr>
            
            <tr>
              <td align="right" valign="top"><div align="left"><span id="noresaltado">Concurso:</span></div></td>
              <td  align="left" valign="top"><div align="left"><?php echo $NombreConcurso; ?></div></td>
            </tr>
            
            <tr>
              <td align="right" valign="top"><div align="left"><span id="noresaltado">Resumen:</span></div></td>
              <td  align="left" valign="top"><div align="left"><?php echo $Descripcion; ?></div></td>
            </tr>
            
            <tr>
              <td></td>
              <td align="right" valign="top"><div align="left"><?php echo $adjunto; ?></div></td>
            </tr>
              
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td valign="top">
              
              <a href="editar_proyecto.php?cadena=<?php echo $cadena2; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $Dato[IdProyecto]; ?>&ban=get" target="_top" title="editar"><img src="iconos/edit.gif" /></a>&nbsp;
              
              <a class="editar" href="eliminar_proyecto.php?cadena=<?php echo $cadena2; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $Dato[IdProyecto]; ?>&ban=get" target="_top" title="eliminar"><img src="iconos/delete.gif" /></a></td>
              </tr>
          </table></td>
          
        
          </tr>
      </table>
    </div>
 <?php	} ?>
  
  
  
  
  
  <div class="listaproyectos">
        <table width="420" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
		$cadena=base64_encode($cadena);		
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_proyectos.php?cadena=$cadena&primero=$anterior&ban=get\" title=\"anterior\"><img src=\"iconos/left.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">
			  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a class=\"editar\" href=\"editar_eliminar_proyectos.php?cadena=$cadena&primero=$siguiente&ban=get\" title=\"siguiente\"><img src=\"iconos/right.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>			  
</div></td>
            </tr>
      </table>
    </div>

<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>";
}
		if($total_items == 0){
			echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$BUSQUEDA_CERO_PROTECTO."</span></div>";
		} 

?>
</div>
</form>
</div>
<?php
	include "pie_pagina.php";
?>

<?php	
	include "./librerias/lib_session.inc";	
	if(!validar_session() || $_SESSION['TipoUsuario'] != 'A'){
		header("location: login.php");
		exit;
	}
	$campo_where = "";

	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	
	$cadena = caracteres_filtros($cadena);
	$ITEMS_CONSULTAS = 30;	
	if(isset($_GET[ban]) && ($_GET[ban]=="get")){
		$cadena=base64_decode($_GET[cadena]);
		$primero = $_GET[primero];			
	}else{
		$cadena=$_POST[cadena];
		$primero = $_POST[primero];	
	}	
	
	if(isset($_GET[accion]) && ($_GET[accion]=="eliminar")){	
		$query=<<<QUERY
			UPDATE usuarios SET EstadoUsuario = 'I'
			WHERE IdUsuario = $_GET[IdUsuario] AND 
			CuentaUsuario != 'Admin'
QUERY;
			$res=actualizar($query);
			if($res==false){
				$cadena=base64_encode($cadena);
				mensajes_advertencia("Error al actualizar Usuario.","editar_eliminar_usuario.php?cadena=$cadena&primero=$primero&IdUsuario=$IdUsuario&ban=get");
			}
			$mensaje_error = "Usuario eliminado con &eacute;xito.";
	}
	
	$cadena=trim($cadena);
	
	if (strlen($cadena)> 0)
		$campo_where .=" AND (CuentaUsuario LIKE '%$cadena%' OR NombresUsuario LIKE '%$cadena%' OR ApellidosUsuario LIKE '%$cadena%')";
	
	if (strlen($primero) == 0){$primero=0;}
	$ultimo = $ITEMS_CONSULTAS + 1;
	
	$fecha_actual = fecha_actual();
	
	$query =<<<QUERY
	SELECT * FROM usuarios WHERE Estadousuario = 'A' 
	$campo_where
	ORDER BY FechaIngreso ASC	
	LIMIT $primero,$ultimo
QUERY;
	$res=consultar($query);
	$cadena = quitar_caracteres_filtros($cadena);
	
	include "encabezado.php";
	include "menu.php";
?>

<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > Actualizar Usuarios </div>
	<form name="consultaconcursosactivos" method="post" action="editar_eliminar_usuarios.php">


<!--Codigo para el buscador -->
	<div id="buscador">
		<div id="titulo_cuadro"><span id="noresaltado">Buscar Usuarios</span></div>
		<table width="0%" border="0" cellspacing="5" cellpadding="2">
		  <tr>
			<td><input name="cadena" type="text" class="textbuscador" value="<?php echo $cadena; ?>" size="20" ></td>
		  </tr>
			<tr>
			<td><div align="center">
			  <input type="submit" name="Submit" value="Buscar">
			  </div></td>
		  </tr>
		</table>
	</div>
<!--Codigo para el buscador -->
	
<div class="parrafoprincipal">
<h1>Lista de usuarios</h1>
<table width="400" cellpadding="2" cellspacing="5">

<?php
	$cont = 0;
	$total_items = count($res);
	if($total_items == 0){
		echo "<tr> <td>".$BUSQUEDA_CERO_CONCURSO."</td> </tr>";
	}
	while(is_array($res) && (list($Id,$Dato) = each($res)) && ($cont < $ultimo - 1)){
		$cont ++;		
		$CuentaUsuario   = quitar_caracteres_filtros($Dato[CuentaUsuario]);
		$NombreUsuario   = quitar_caracteres_filtros($Dato[NombresUsuario]);
		$ApellidoUsuario = quitar_caracteres_filtros($Dato[ApellidosUsuario]);
		$entorno=<<<ENTORNO
		<a href="editar_eliminar_usuarios.php?accion=eliminar&IdUsuario=$Dato[IdUsuario]&cadena=$cadena&primero=$primero&ban=get" target="_top" onClick="javascripts: return confirm('¿Deseas realmente eliminar este usuario?.');" title="eliminar"><img src="iconos/delete.gif" /></a>
ENTORNO;
		if($CuentaUsuario == 'Admin'){
			$entorno="&nbsp;";
		}
		$cadena2=base64_encode($cadena);		
?>
      <tr>
        <td  width="170"><a href="editar_usuario.php?accion=editara&IdUsuario=<?php echo $Dato[IdUsuario]; ?>&cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>" target="_top" ><?php echo $CuentaUsuario; ?></a>&nbsp;(<?php echo $NombreUsuario; ?>&nbsp;<?php echo $ApellidoUsuario; ?>)</td>
        <td width="5%"><div align="center"><a href="editar_usuario.php?accion=editara&IdUsuario=<?php echo $Dato[IdUsuario]; ?>&cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>" target="_top" title="editar"><img src="iconos/edit.gif" /></a></div></td>
    	<td width="5%"><div align="center"><?php echo $entorno; ?></div></td>
   	    
      </tr>
<?php }		?>
    </table>
    


<div class="listaproyectos">
        <table width="420" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
		$cadena=base64_encode($cadena);		
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_usuarios.php?cadena=$cadena&primero=$anterior&ban=get\" title=\"anterior\"><img src=\"iconos/left.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">
			  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_usuarios.php?cadena=$cadena&primero=$siguiente&ban=get\" title=\"siguiente\"><img src=\"iconos/right.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>			  
</div></td>
            </tr>
      </table>
    </div>
      
<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>"; 
}
?>


</div>
</form>
</div>

<?php
	include "pie_pagina.php";
?>
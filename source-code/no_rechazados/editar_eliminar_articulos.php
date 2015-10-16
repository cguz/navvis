<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	if(isset($_GET[accion]) && $_GET[accion] == "eliminar"){	
		if(isset($_GET[IdArticulo]) && $_GET[IdArticulo] != ""){
			$query=<<<QUERY
			UPDATE articulos set EstadoArticulo = 'I' 
			WHERE IdArticulo = $_GET[IdArticulo]
QUERY;
			$res=actualizar($query); 
			
			if($res==true)
			{
				$query =<<<QUERY
				SELECT ImagenArticulo FROM articulos WHERE IdArticulo=$IdArticulo AND EstadoArticulo = 'I' 
QUERY;
				$res_ar=consultar($query);
				//$borrad="hola ..$res_ar";
				if(is_array($res_ar) && (list($Id,$Dato1) = each($res_ar))){
					$Archivo = $Dato1[ImagenArticulo];
					$borrad=borrar_Archivo($Archivo);
				}
			}
			
			if($res==false){
				$mensaje_error = "Error al eliminar.";
			}else{
				$mensaje_error = "Articulo eliminado correctamente.";
			}
		}
	}
	$ITEMS_CONSULTAS = 40;	
	$primero = $_GET[primero];	
	if (strlen($primero) == 0){$primero=0;}
	$ultimo = $ITEMS_CONSULTAS + 1;
	
	$query=<<<QUERY
	SELECT * FROM articulos WHERE EstadoArticulo = 'A'
	ORDER BY IdArticulo DESC
	LIMIT 1
QUERY;
	$res2 = consultar($query);
	$Titulo = "";
	$TextoArticulo = "";
	$FirmaAutorArticulo = "";
	$Imagen = "";
	if(is_array($res2) && (list($Id,$Dato) = each($res2))){
		$Titulo = quitar_caracteres_filtros($Dato[TituloArticulo]);
		$TextoArticulo = stripslashes($Dato[TextoArticulo]);
		$FirmaAutorArticulo = quitar_caracteres_filtros($Dato[FirmaAutorArticulo]);
		$Imagen = $Dato[ImagenArticulo];
	}/*else{
		mensajes_advertencia("No hay informaci&oacute;n que mostrar.","principal.php");
	}*/
	$query=<<<QUERY
	SELECT * FROM articulos WHERE EstadoArticulo = 'A'
	ORDER BY FechaIngresoArticulo DESC
	LIMIT $primero,$ultimo
QUERY;
	$res = consultar($query);
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > Actualizar Art&iacute;culo</div>	

<div id="buscador">
<table border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td><div class="boton_nuevo"><a href="agregar_articulos.php" target="_top" style="padding-left:5px; padding-right:5px;">Nuevo art&iacute;culo</a></div></td>
  </tr>
</table>
  
</div>

<div class="parrafoprincipal">
<h1>Actualizar art&iacute;culos</h1>
<div id="lista">
<ul>
      <?php 
	$cont = 0;
	$total_items = count($res);
	while(is_array($res) && (list($Id,$Dato) = each($res)) && ($cont < $ultimo - 1)){
	$cont ++;
?>
<li> 
<?php echo $Dato[TituloArticulo ]; ?>&nbsp;(<?php echo fecha_espenol(substr($Dato[FechaIngresoArticulo ],0,10)); ?>)
        
<a href="editar_articulos.php?primero=<?php echo $primero; ?>&IdArticulo=<?php echo $Dato[IdArticulo]; ?>" target="_top" title="editar art&iacute;culo"><img src="iconos/edit.gif" /></a>
        
<a href="editar_eliminar_articulos.php?accion=eliminar&primero=<?php echo $primero; ?>&IdArticulo=<?php echo $Dato[IdArticulo]; ?>" target="_top" onClick="javascripts: return confirm('¿Deseas realmente eliminar este articulo?.');" title="eliminar art&iacute;culo"><img src="iconos/delete.gif" /></a></li>

      <?php } ?>
</ul>
      
</div>
    
    

<div class="listaproyectos">
<table width="60%" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
			
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_articulos.php?primero=$anterior\" title=\"anterior\"><img src=\"iconos/left.gif\"></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">
			  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_articulos.php?primero=$siguiente\" title=\"siguiente\"><img src=\"iconos/right.gif\"></a>";
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
</div>
<?php
	include "pie_pagina.php";
?>

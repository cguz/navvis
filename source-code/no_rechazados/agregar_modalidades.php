<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	
	$mensaje_error = "";
	if(isset($_GET[accion]) && $_GET[accion] == "eliminar"){	
		if(isset($_GET[IdModalidad]) && $_GET[IdModalidad] != ""){
			$query =<<<QUERY
			SELECT * FROM concursos
			WHERE IdModalidad  = $_GET[IdModalidad]
QUERY;
			$res=consultar($query);
			$html_eliminar = "";
			if(is_array($res) && count($res)<=0){
				$query=<<<QUERY
				UPDATE modalidades set EstadoModalidad = 'I' 
				WHERE IdModalidad = $_GET[IdModalidad]
QUERY;
				$res=actualizar($query); 
				if($res==false){
					$mensaje_error = "Error al eliminar.";
				}else{
					$mensaje_error = "Modalidad eliminada correctamente.";
				}
			}else{
				$mensaje_error = "Modalidad no eliminada tiene concursos relacionados.";
			}
		}
	}
	if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
		if(isset($_POST[NombreModalidad]) && $_POST[NombreModalidad] != ""){
			$NombreModalidad = caracteres_filtros($_POST[NombreModalidad]);
			$query=<<<QUERY
			INSERT INTO modalidades (IdModalidad, NombreModalidad, EstadoModalidad)
			VALUES ('','$NombreModalidad','A')
QUERY;
			$res=insertar($query);
			if($res==false){
				$mensaje_error = $ERROR_INSERTAR_MODALIDAD;
			}else{
				header("location: agregar_modalidades.php");
				exit;
			}
		}else $mensaje_error = $ERROR_AGREGAR_NOMBRE_MODALIDAD;				
	}
	$query="SELECT * FROM modalidades WHERE EstadoModalidad = 'A'";
	$resultado = consultar($query);	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; actualizar modalidades </div>
<form name="form1" method="post" action="agregar_modalidades.php?accion=agregar">

	<div id="buscador">
		<div id="titulo_cuadro"><span id="noresaltado">Nueva modalidad:</span></div>
		<table width="0%" border="0" cellspacing="5" cellpadding="2">
		  <tr>
			<td>
          <input name="NombreModalidad" type="text" size="20" maxlength="20">&nbsp;<input type="submit" name="Submit" value="Agregar">
        </td>
		  </tr>
		</table>
	</div>
 
<div class="parrafoprincipal"> 
<h1>Editar eliminar modalidades concursos</h1>


<table width="300" cellpadding="2" cellspacing="5">
    
		<?php
		if(is_array($resultado)){
			while(list($key,$registro)=each($resultado)){
			$query =<<<QUERY
			SELECT * FROM concursos 
			WHERE IdModalidad  = $registro[IdModalidad]
QUERY;
			$res=consultar($query);
			$html_eliminar = "";
			if(is_array($res) && count($res)<=0){
				$html_eliminar = "<a href=\"agregar_modalidades.php?accion=eliminar&IdModalidad=".$registro[IdModalidad]."\" target=\"_top\" onClick=\"javascripts: return confirm('¿Deseas realmente eliminar esta modalidad?.');\" title=\"eliminar\"><img src=\"iconos/delete.gif\"/></a>";
			}else $html_eliminar = "&nbsp;";
		?>
  <tr>
    <td width="170"><?php echo quitar_caracteres_filtros($registro[NombreModalidad]); ?></td>
    <td width="5%"><div align="center"><a  href="<?php echo "editar_modalidades.php?IdModalidad=".$registro[IdModalidad]; ?>" title="editar"><img src="iconos/edit.gif" /></a></div></td>
    <td width="5%"><?php echo $html_eliminar; ?></td>
  </tr>
        <?php	
			
			}
		}
?>
		</table>

<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>"; 
}
?>
</div>
</form></div>
<?php
	include "pie_pagina.php";
?>
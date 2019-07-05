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
		if(isset($_GET[IdDiciplina]) && $_GET[IdDiciplina] != ""){
			$query =<<<QUERY
			SELECT * FROM concursos 
			WHERE IdDiciplina  = $_GET[IdDiciplina]
QUERY;
			$res=consultar($query);
			$html_eliminar = "";
			if(is_array($res) && count($res)<=0){
				$query=<<<QUERY
				UPDATE diciplinas set EstadoDiciplina = 'I' 
				WHERE IdDiciplina = $_GET[IdDiciplina]
QUERY;
				$res=actualizar($query); 
				if($res==false){
					$mensaje_error = "Error al eliminar.";
				}else{
					$mensaje_error = "Modalidad eliminada correctamente.";
				}
			}else $mensaje_error = "Diciplina no eliminada tiene concursos relacionados.";
		}
	}
	if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
		if(isset($_POST[NombreDiciplina]) && $_POST[NombreDiciplina] != ""){
			$NombreDiciplina = caracteres_filtros($_POST[NombreDiciplina]);
			$query=<<<QUERY
			INSERT INTO diciplinas (IdDiciplina, NombreDiciplina, EstadoDiciplina)
			VALUES ('','$NombreDiciplina','A')
QUERY;
			$res=insertar($query);
			if($res==false){
				$mensaje_error = $ERROR_INSERTAR_DICIPLINA;
			}else{			
				header("location: agregar_diciplinas.php");
				exit;
			}

		}else $mensaje_error = $ERROR_AGREGAR_NOMBRE_DICIPLINA;
	}
	$query="SELECT * FROM diciplinas WHERE EstadoDiciplina = 'A'";
	$resultado = consultar($query);	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; actualizar disciplinas </div>

<form name="form1" method="post" action="agregar_diciplinas.php?accion=agregar">

  
  <div id="buscador">
  <table width="0%" border="0" cellspacing="5" cellpadding="2">
  <tr>
  <td><div id="titulo_cuadro"><span id="noresaltado">Nueva disciplina:</span></div></td>
  </tr>
    <tr>
      <td>
          <input name="NombreDiciplina" type="text" size="20" maxlength="20">&nbsp;
        <input type="submit" name="Submit" value="Agregar">
      </td>
    </tr>
  </table>
</div>
  
<div class="parrafoprincipal">
<h1>Actualizar disciplinas</h1>
  
<table width="300" cellpadding="2" cellspacing="5">
<?php
		if(is_array($resultado)){
			while(list($key,$registro)=each($resultado)){
				$query =<<<QUERY
				SELECT * FROM concursos 
				WHERE IdDiciplina  = $registro[IdDiciplina]
QUERY;
				$res=consultar($query);
				$html_eliminar = "";
				if(is_array($res) && count($res)<=0){
					$html_eliminar = "<a href=\"agregar_diciplinas.php?accion=eliminar&IdDiciplina=".$registro[IdDiciplina]."\" target=\"_top\" onClick=\"javascripts: return confirm('¿Deseas realmente eliminar esta disciplina?.');\" title=\"eliminar\"><img src=\"iconos/delete.gif\"/></a>";
				}else $html_eliminar = "&nbsp;";
				
				
				?>
<tr>
    <td width="170"><?php echo quitar_caracteres_filtros($registro[NombreDiciplina]); ?></td>
    <td width="5%"><div align="center"><a href="<?php echo "editar_diciplinas.php?IdDiciplina=".$registro[IdDiciplina]; ?>" title="editar"><img src="iconos/edit.gif" /></a></div></td>
    <td width="5%"><div align="center"><?php echo $html_eliminar;?></div>                </td>
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
</form>
</div>
<?php
	include "pie_pagina.php";
?>

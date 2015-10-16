<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	if(!isset($_GET[IdComentario]) || $_GET[IdComentario] == ""){
		mensajes_advertencia("No hay informaci&oacute;n que mostrar","agregar_comentarios.php");
	}
	$mensaje_error = "";
	$_POST[NombreComentario] = trim($_POST[NombreComentario]);
	$_POST[Comentario] = trim($_POST[Comentario]);
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[NombreComentario]) && $_POST[NombreComentario] != ""){
			if(isset($_POST[Comentario]) && $_POST[Comentario] != ""){
				$NombreComentario = caracteres_filtros($_POST[NombreComentario]);
				$Comentario = caracteres_filtros($_POST[Comentario]);
				$query=<<<QUERY
				UPDATE comentarios set NombreComentario = '$_POST[NombreComentario]',  Comentario = '$_POST[Comentario]'
				WHERE IdComentario = $_GET[IdComentario]
QUERY;
				$res=actualizar($query);
				if($res==false){
					mensajes_advertencia("Error al editar comentario","agregar_comentarios.php");
				}else{			
					mensajes_exito("Comentario editado exitosamente","agregar_comentarios.php");
				}
			}else $mensaje_error = "Debe colocar el Comentario a realizar.";
		}else $mensaje_error = "Debe colocar el Nombre del Comentario.";
	}else{
		$query="SELECT * FROM comentarios WHERE EstadoComentario = 'A' AND IdComentario = '$_GET[IdComentario]'";
		$resultado = consultar($query);	
		if(is_array($resultado) && (list($key,$registro)=each($resultado))){		
				$_POST[NombreComentario] = quitar_caracteres_filtros($registro[NombreComentario]);
				$_POST[Comentario] = quitar_caracteres_filtros($registro[Comentario]);		
		}else{
			mensajes_advertencia("No hay informaci&oacute;n que mostrar","agregar_comentarios.php");
		}
	}
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="agregar_comentarios.php">actualizar comentarios</a> &gt; editar comentario</div>
<div id="formulariologin">
<form name="form1" method="post" action="editar_comentarios.php?accion=editar&IdComentario=<?php echo $_GET[IdComentario]; ?>">
<div align="center">
  <table border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td valign="bottom"><div id="titulo_cuadro"><span id="noresaltado">a&ntilde;adir comentario</span></div></td>
    </tr>
    <tr>
      <td valign="bottom"><div align="left"><span class="noresaltado">nombre</span></div></td>
      </tr>
    <tr>
      <td valign="top"><input name="NombreComentario" type="text" id="NombreComentario" size="32" maxlength="60" value="<?php echo $_POST[NombreComentario]; ?>"></td>
      </tr>
    <tr>
      <td valign="bottom" height="30px"><div align="left"><span class="noresaltado">comentario</span></div></td>
      </tr>
    <tr>
      <td valign="top"><textarea name="Comentario" cols="34" rows="5" id="Comentario"><?php echo $_POST[Comentario]; ?></textarea></td>
      </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      </tr>
  </table>
  <br />
  </div>
  <div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>
</form>
</div>
</div>
<?php
	include "pie_pagina.php";
?>
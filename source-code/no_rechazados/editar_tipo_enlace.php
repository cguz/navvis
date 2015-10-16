<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	if(!isset($_GET[IdTipo]) || $_GET[IdTipo] == ""){
		mensajes_advertencia("No hay informaci&oacute;n que mostrar","tipo_enlace.php");
	}
	$mensaje_error = "";
	$_POST[NombreTipo] = trim($_POST[NombreTipo]);
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[NombreTipo]) && $_POST[NombreTipo] != ""){
			$NombreTipo = caracteres_filtros($_POST[NombreTipo]);
			$query=<<<QUERY
			UPDATE tiposdeenlaces set TipoEnlace = '$NombreTipo'
			WHERE IdTipo = $_GET[IdTipo]
QUERY;
			$res=actualizar($query);
			if($res==false){
				mensajes_advertencia("Error al editar tipo de enlace","tipo_enlace.php");
			}else{			
				mensajes_exito("Tipo de Enlace editado exitosamente","tipo_enlace.php");
			}

		}else $mensaje_error = "Debe insertar la descripci&oacute;n del tipo de enlace.";
	}else{
		$query="SELECT * FROM tiposdeenlaces WHERE IdTipo = $_GET[IdTipo] AND EstadoTipo = 'A'";
		$resultado = consultar($query);	
		if(is_array($resultado) && (list($key,$registro)=each($resultado))){		
				$_POST[NombreTipo] = quitar_caracteres_filtros($registro[TipoEnlace]);
		}else{
			mensajes_advertencia("No hay informaci&oacute;n que mostrar","tipo_enlace.php");
		}
	}
	$query="SELECT * FROM tiposdeenlaces WHERE EstadoTipo = 'A'";
	$resultado = consultar($query);	
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="tipo_enlace.php">tipo de enlace</a> &gt; actualizar  enlace </div>
<div class="parrafoprincipal">
<h1>Actualizar tipo de enlace</h1>
    <div id="formulariologin">
    <div align="center">

<form name="form1" method="post" action="editar_tipo_enlace.php?accion=editar&IdTipo=<?php echo $_GET[IdTipo]; ?>">
<input name="NombreTipo" type="text" id="NombreTipo" value="<?php echo $_POST[NombreTipo]; ?>" size="20" maxlength="150">
&nbsp;<input type="submit" name="Submit" value="Actualizar">
<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>"; 
}
?>
  </form>
</div>
</div>
  </div>
</div>
<?php
	include "pie_pagina.php";
?>

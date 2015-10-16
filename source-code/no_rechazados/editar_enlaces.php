<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	if(!isset($_GET[IdEnlace]) || $_GET[IdEnlace] == ""){
		mensajes_advertencia("No hay informaci&oacute;n que mostrar","agregar_enlaces.php");
	}
	$mensaje_error = "";
	$_POST[enlace] = trim($_POST[enlace]);
	$_POST[descripcion] = trim($_POST[descripcion]);
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[enlace]) && $_POST[enlace] != ""){
			if(ValidarUrl($_POST[enlace])){	
				$enlace = caracteres_filtros($_POST[enlace]);
				$descripcion = caracteres_filtros($_POST[descripcion]);
				$query=<<<QUERY
				UPDATE enlaces set Enlace = '$_POST[enlace]', DescripcionEnlace = '$_POST[descripcion]', IdTipo = '$_POST[tipoenlace]'
				WHERE IdEnlace = $_GET[IdEnlace]
QUERY;
				$res=actualizar($query);
				if($res==false){
					mensajes_advertencia("Error al editar enlace","agregar_enlaces.php");
				}else{			
					mensajes_exito("Enlace editado exitosamente","agregar_enlaces.php");
				}
			}else $mensaje_error = "Verifique el enlace.";
		}else $mensaje_error = "Debe colocar la descripci&oacute;n del enlace.";
	}else{
		$query="SELECT * FROM enlaces, tiposdeenlaces WHERE enlaces.IdTipo = tiposdeenlaces.IdTipo AND EstadoEnlace = 'A' AND IdEnlace = $_GET[IdEnlace]";
		$resultado = consultar($query);	
		if(is_array($resultado) && (list($key,$registro)=each($resultado))){		
				$_POST[enlace] = quitar_caracteres_filtros($registro[Enlace]);
				$_POST[descripcion] = quitar_caracteres_filtros($registro[DescripcionEnlace]);
				$_POST[tipoenlace] = quitar_caracteres_filtros($registro[IdTipo]);		
		}else{
			mensajes_advertencia("No hay informaci&oacute;n que mostrar","agregar_enlaces.php");
		}
	}
	$arreglo_tipos_enlace = retornar_tipos_enlace();
	if(count($arreglo_tipos_enlace) <= 0){
		mensajes_advertencia("No existen tipos de enlaces","principal.php");
	}	
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="tipo_enlace.php">lista de enlace</a> &gt; actualizar enlace </div>
<h1>Actualizar enlace</h1>

<form name="form1" method="post" action="editar_enlaces.php?accion=editar&IdEnlace=<?php echo $_GET[IdEnlace]; ?>">
<div id="formulariologin"> 
  <table width="100%" align="center" cellpadding="2" cellspacing="5">
    <tr>
      <td><div align="right"><span class="noresaltado">Direcci&oacute;n </span></div></td>
      <td>
        <input name="enlace" type="text" id="enlace" size="20" maxlength="255" value="<?php echo $_POST[enlace]; ?>">      </td>
      </tr>
    <tr>
      <td valign="top"><div align="right"><span class="noresaltado">Descripci&oacute;n</span></div></td>
      <td><textarea name="descripcion" cols="30" rows="5" id="descripcion"><?php echo $_POST[descripcion]; ?></textarea></td>
    </tr>
    <tr>
      <td><div align="right"><span class="noresaltado">Tipo enlace:</span></div></td>
      <td>
        <select name="tipoenlace" id="tipoenlace">
              <?php
	 while(is_array($arreglo_tipos_enlace) && (list($id,$dato)=each($arreglo_tipos_enlace))){
			$seleccion = "";
			if($id == $_POST[tipoenlace]){
				$seleccion = "selected";			
			}
		?>		
          <option value="<?php echo $id; ?>" <?php echo $seleccion; ?>><?php echo $dato; ?></option>
              <?php } ?>
        </select></td>
      </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="Submit" value="Enviar"></td>
      </tr>
  </table>
</div>
</form>
<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>"; 
}
?>
</div>
<?php
	include "pie_pagina.php";
?>

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
		if(isset($_GET[IdEnlace]) && $_GET[IdEnlace] != ""){
			$query=<<<QUERY
			UPDATE enlaces set EstadoEnlace = 'I' 
			WHERE IdEnlace = $_GET[IdEnlace]
QUERY;
			$res=actualizar($query); 
			if($res==false){
				$mensaje_error = "Error al eliminar.";
			}else{
				$mensaje_error = "Enlace eliminado correctamente.";
			}
		}
	}

	$_POST[enlace] = trim($_POST[enlace]);
	$_POST[descripcion] = trim($_POST[descripcion]);
	if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
		if(isset($_POST[enlace]) && $_POST[enlace] != ""){
			if(ValidarUrl($_POST[enlace])){			
				$enlace = caracteres_filtros($_POST[enlace]);
				$descripcion = caracteres_filtros($_POST[descripcion]);
			
				if (verificar_enlace($enlace)==1)
				{
					$query=<<<QUERY
					INSERT INTO enlaces (IdEnlace, Enlace,  IdTipo, EstadoEnlace, DescripcionEnlace)
					VALUES ('','$enlace','$_POST[tipoenlace]','A','$descripcion')
QUERY;
					$res=insertar($query);
					if($res==false){
						$mensaje_error = "Error al insertar enlace";
					}else{			
						header("location: agregar_enlaces.php");
						exit;
					}
				}else $mensaje_error = "El enlace ya se encuentra registrado.";
			}else $mensaje_error = "Verifique el enlace.";

		}else $mensaje_error = "Debe colocar la descripci&oacute;n del enlace.";
	}
	$arreglo_tipos_enlace = retornar_tipos_enlace();
	if(count($arreglo_tipos_enlace) <= 0){
		mensajes_advertencia("No existen tipos de enlaces","principal.php");
	}
	$query="SELECT * FROM enlaces, tiposdeenlaces 
	WHERE enlaces.IdTipo = tiposdeenlaces.IdTipo AND EstadoEnlace = 'A' ORDER BY enlaces.idTipo";
	$resultado = consultar($query);	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; Actualizar Enlace </div>
<form name="form1" method="post" action="agregar_enlaces.php?accion=agregar">
<div id="buscador">

  <table width="0%" border="0" cellspacing="5" cellpadding="2">
  <tr>
  <td><div id="titulo_cuadro"><span id="noresaltado">A&ntilde;adir enlace</span></div></td>
  </tr>
    <tr>
      <td>
          <input name="enlace" type="text" id="enlace" size="20" maxlength="255"></td>
    </tr>
    <tr>
      <td><textarea name="descripcion" cols="20" rows="3" id="descripcion"></textarea></td>
    </tr>
    <tr>
      <td><select name="tipoenlace" id="tipoenlace">
<?php
	 while(is_array($arreglo_tipos_enlace) && (list($id,$dato)=each($arreglo_tipos_enlace))){
?>
        <option value="<?php echo $id; ?>"><?php echo $dato; ?></option>
<?php } ?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Agregar"></td>
    </tr>
  </table>
</div>
<div class="parrafoprincipal">
<h1>Lista de enlaces</h1>

<table width="400" cellpadding="2" cellspacing="5">
        <tr>
          <td width="31%"><span id="noresaltado">Enlace</span></td>
          <td width="25%"><span id="noresaltado">Tipo enlace</span></td>
          <td></td>
          <td></td>
        </tr>
<?php
		if(is_array($resultado)){
			while(list($key,$registro)=each($resultado)){
?>
		<tr>
          <td valign="top"><a href="http://<?php echo quitar_caracteres_filtros($registro[Enlace]);?>" target="_blank" title="ir a enlace"><?php echo quitar_caracteres_filtros($registro[Enlace]);?></a></td>
          <td valign="top"><?php echo quitar_caracteres_filtros($registro[TipoEnlace]); ?></td>
          <td  width="7%" valign="top"><?php echo "<a href=\"editar_enlaces.php?IdEnlace=".$registro[IdEnlace]."\" title=\"editar\"><img src=\"iconos/edit.gif\" /></a>"; ?></td>
          <td  width="7%" valign="top"><?php echo "<a href=\"agregar_enlaces.php?accion=eliminar&IdEnlace=".$registro[IdEnlace]."\" target=\"_top\" onClick=\"javascripts: return confirm('¿Deseas realmente eliminar este enlace?.');\" title=\"eliminar\"><img src=\"iconos/delete.gif\"/></a>"; ?></td>
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

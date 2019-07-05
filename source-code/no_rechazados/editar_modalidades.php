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
	$_POST[NombreModalidad] = trim($_POST[NombreModalidad]);
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[NombreModalidad]) && $_POST[NombreModalidad] != ""){
			$NombreModalidad = caracteres_filtros($_POST[NombreModalidad]);
			$query=<<<QUERY
			UPDATE modalidades set NombreModalidad  = '$NombreModalidad' 
			WHERE IdModalidad = $_GET[IdModalidad]
QUERY;
echo  "$query";
			$res=actualizar($query);
			if($res==false){
				mensajes_advertencia("Error al editar modalidad.","agregar_modalidades.php");
			}else{			
				mensajes_exito("Modalidad editada con &eacute;xito.","agregar_modalidades.php");
			}

		}else $mensaje_error = $ERROR_AGREGAR_NOMBRE_MODALIDAD;
	}
	$query="SELECT * FROM modalidades WHERE IdModalidad = $_GET[IdModalidad]";
	$resultado = consultar($query);	
	if(!is_array($resultado) && count($resultado)<=0){
		mensajes_advertencia("No hay modalidad que editar.","agregar_modalidades.php");
	}
	list($key,$registro)=each($resultado);
	$contenido_descrip = $registro[NombreModalidad];
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="agregar_modalidades.php">actualizar modalidades</a> &gt; editar modalidad  </div>

<div class="parrafoprincipal">
<h1>Actualizar modalidad concurso</h1>
    <div id="formulariologin">
<form name="form1" method="post" action="editar_modalidades.php?accion=editar&IdModalidad=<?php echo $_GET[IdModalidad]; ?>"> 
  <table width="100%" cellpadding="2" cellspacing="5" >
    <tr>
      <td>
          <div align="center">
            <input name="NombreModalidad" type="text" size="20" maxlength="20" value="<?php echo $contenido_descrip; ?>">
            &nbsp;
            <input type="submit" name="Submit" value="Actualizar">
          </div></td>
      </tr>
  </table>
  <div align="center">
    <?php if($mensaje_error!=""){
echo "<span class=\"alerta\">".$mensaje_error."</span>"; 
}
?>
  </div>
</form>

</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>
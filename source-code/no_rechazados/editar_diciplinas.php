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
	$_POST[NombreDiciplina] = trim($_POST[NombreDiciplina]);
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[NombreDiciplina]) && $_POST[NombreDiciplina] != ""){
			$NombreDiciplina = caracteres_filtros($_POST[NombreDiciplina]);
			$query=<<<QUERY
			UPDATE diciplinas set NombreDiciplina = '$NombreDiciplina' 
			WHERE IdDiciplina = $_GET[IdDiciplina]
QUERY;
			$res=actualizar($query);
			if($res==false){
				mensajes_advertencia("Error al editar Disciplina.","agregar_diciplinas.php");
			}else{			
				mensajes_exito("Disciplina editada con &eacute;xito.","agregar_diciplinas.php");
			}

		}else $mensaje_error = $ERROR_AGREGAR_NOMBRE_DICIPLINA;
	}
	$query="SELECT * FROM diciplinas WHERE IdDiciplina = $_GET[IdDiciplina]";
	$resultado = consultar($query);	
	if(!is_array($resultado) && count($resultado)<=0){
		mensajes_advertencia("No hay Disciplina que editar.","agregar_diciplinas.php");
	}
	list($key,$registro)=each($resultado);
	$contenido_descrip = $registro[NombreDiciplina];
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; actualizar disciplinas &gt; editar disciplina </div>

<div class="parrafoprincipal">
<h1>Actualizar disciplina concursos</h1>
    <div id="formulariologin">
    
<form name="form1" method="post" action="editar_diciplinas.php?accion=editar&IdDiciplina=<?php echo $_GET[IdDiciplina]; ?>">
  <table width="100%" cellpadding="2" cellspacing="5" >
    <tr>
      <td>
        <div align="center">
          <input name="NombreDiciplina" type="text" size="20" maxlength="20" value="<?php echo $contenido_descrip; ?>">&nbsp;
        <input type="submit" name="Submit" value="Actualizar"></div></td>
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


<?php
	include "./librerias/lib_session.inc";	
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	$campo_where = "";
	if($_SESSION['TipoUsuario'] != 'A'){
		$campo_where .= " AND proyectos.IdUsuario = $_SESSION[id_usuario_actual]";
	}
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";

	$cadena=$_GET[cadena];
	$primero=$_GET[primero];
	$IdProyecto=$_GET[IdProyecto];
	
	$cadena=base64_encode($cadena);	


	$query =<<<QUERY
	SELECT *, proyectos.Enlace as EnlaceP FROM proyectos, concursos 
	WHERE proyectos.IdConcurso = concursos.IdConcurso
	AND EstadoProyecto = 'A' AND IdProyecto = $IdProyecto $campo_where	
QUERY;

	$res=consultar($query);
	if(!is_array($res)){
		mensajes_advertencia("No hay Proyecto que eliminar","principal.php");
	}
	list($Id,$Dato) = each($res);
	
	$NombreProyecto = quitar_caracteres_filtros($Dato[NombreProyecto]);
	$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
	$Enlace = "http://".quitar_caracteres_filtros($Dato[EnlaceP]);
	$Descripcion = substr(stripslashes($Dato[Texto]),0,100);

	include "encabezado.php";
	include "menu.php";	
?>
<div id="contenido">
<div id="navegacion2"> <a href="principal.php">inicio</a> &gt; <a href="editar_eliminar_proyectos.php">actualizar proyectos</a> &gt; eliminar proyecto</div>
<div id="parrafoprincipal">
<div class="listaproyectos">
<div id="formulariologin">
<div align="center"><p><span id="noresaltado">Proyecto:</span>&nbsp;<?php echo $NombreProyecto; ?><br /></p>


<p><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Dato[Imagen]; ?>" width="150"><br /></p>
<p><span id="noresaltado">Concurso:</span>&nbsp;<?php echo $NombreConcurso; ?><br />
<span id="noresaltado">Resumen:</span> &nbsp;<?php echo $Descripcion; ?></p>
</div>                

<table width="100%"  border="0" cellpadding="5" cellspacing="5">
      <tr>
        <td colspan="2"><div align="center">&iquest;Confirma que desea eliminar el proyecto? </div></td>
        </tr>
      <tr>
        <td width="47%"><div align="right"><a href="editar_eliminar_proyectos.php?cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $IdProyecto; ?>&ban=get&eliminar=SI"> SI </a> </div></td>
        <td width="50%"><div align="left"><a href="editar_eliminar_proyectos.php?cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $IdProyecto; ?>&ban=get">NO </a></div></td>
      </tr>
    </table>

</div>
</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>


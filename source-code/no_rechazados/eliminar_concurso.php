<?php
	include "./librerias/lib_session.inc";	
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	$campo_where = "";
	if($_SESSION['TipoUsuario'] != 'A'){
		$campo_where .= " AND IdUsuario = $_SESSION[id_usuario_actual]";
	}
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";

	$cadena=$_GET[cadena];
	$Modalidad=$_GET[Modalidad];
	$Diciplina=$_GET[Diciplina];
	$primero=$_GET[primero];
	$IdConcurso=$_GET[IdConcurso];
	
	$cadena=base64_encode($cadena);
	$arreglo_diciplinas = retornar_diciplinas();
	if(count($arreglo_diciplinas) <= 0){
		mensajes_advertencia($NO_HAY_DICIPLINAS,"editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Diciplina=$Diciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
	}
	$arreglo_modalidades = retornar_modalidades();
	if(count($arreglo_modalidades) <= 0){
		mensajes_advertencia($NO_HAY_MODALIDADES,"editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Diciplina=$Diciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
	}
	
	$query =<<<QUERY
	SELECT * FROM proyectos WHERE EstadoProyecto = 'A'
	AND IdConcurso = $IdConcurso
QUERY;
	$res=consultar($query);
	if(is_array($res) && count($res) > 0){
		mensajes_advertencia("Este Concurso tiene proyectos relacionados, debe eliminar primero estos proyectos","editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Diciplina=$Diciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
	}
	
	$query =<<<QUERY
	SELECT * FROM concursos WHERE EstadoConcurso = 'A'
	AND IdConcurso = $IdConcurso $campo_where 
QUERY;
	$res=consultar($query);
	if(!is_array($res)){
		mensajes_advertencia("No hay concurso que eliminar","principal.php");
	}
	list($Id,$Dato) = each($res);
	$id_diciplina = $Dato[IdDiciplina];
	$id_modalidad = $Dato[IdModalidad];
	
	$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
	$Convocante = quitar_caracteres_filtros($Dato[Convocante]);
	$Descripcion = substr(quitar_caracteres_filtros($Dato[Descripcion]),0,150)."...";
	$Enlace = quitar_caracteres_filtros($Dato[Enlace]);
	include "encabezado.php";
	include "menu.php";		
?>
<div id="contenido">
<div id="navegacion2"> <a href="principal.php">inicio</a> &gt; <a href="editar_eliminar_concurso.php">actualizar convocatoria</a> &gt; eliminar concurso</div>
<div id="parrafoprincipal6">
<div class="listaproyectos">
<div id="formulariologin">


	
<div class="centrartextoformulariologin">
<span id="noresaltado">Nombre concurso:</span> &nbsp;<?php echo $NombreConcurso; ?><br />
    <span id="noresaltado">Convocante Concurso:</span> &nbsp;<?php echo $Convocante; ?><br />
    <span id="noresaltado">Disciplina:</span> &nbsp;<?php echo $arreglo_diciplinas[$id_diciplina]; ?><br />
    <span id="noresaltado">Modalidad:</span> &nbsp;<?php echo $arreglo_modalidades[$id_modalidad]; ?><br />
    <span id="noresaltado">Resumen:</span> &nbsp;<?php echo $Descripcion; ?><br />
    <span id="noresaltado">Fecha entrega</span>: &nbsp;<?php echo fecha_espenol($Dato[FechaEntrega]); ?><br />
    <span id="noresaltado">Enlace:</span> &nbsp;<a href="<?php echo $Enlace; ?>"><?php echo $Enlace; ?></a><br />
  
</div>
<div align="center"><br />
  &iquest;Confirma que desea eliminar el concurso?<br />
  
  <a href="editar_eliminar_concurso.php?cadena=<?php echo $cadena; ?>&Modalidad=<?php echo $Modalidad; ?>&Diciplina=<?php echo $Diciplina; ?>&primero=<?php echo $primero; ?>&IdConcurso=<?php echo $IdConcurso; ?>&ban=get&eliminar=SI"> SI</a>&nbsp;&nbsp;
  
  <a href="editar_eliminar_concurso.php?cadena=<?php echo $cadena; ?>&Modalidad=<?php echo $Modalidad; ?>&Diciplina=<?php echo $Diciplina; ?>&primero=<?php echo $primero; ?>&IdConcurso=<?php echo $IdConcurso; ?>&ban=get">NO </a>
  
</div>
</div>
</div>
</div>
</div>
<?php
include "pie_pagina.php";
?>

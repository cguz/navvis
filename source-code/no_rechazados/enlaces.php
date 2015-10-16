<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	
	$arreglo_tipos_enlace = retornar_tipos_enlace();
	if(count($arreglo_tipos_enlace) <= 0){
		mensajes_advertencia("No existen tipos de enlaces","principal.php");
	}
	
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > enlaces</div>
<div class="parrafoprincipal">   

<?php
	 while(is_array($arreglo_tipos_enlace) && (list($id,$dato)=each($arreglo_tipos_enlace))){
	$query=<<<QUERY
	SELECT * FROM enlaces WHERE IdTipo = $id AND EstadoEnlace = 'A'
QUERY;
	$res=consultar($query);
	if(is_array($res) && count($res)>0){
?>

<p>
<h1><span id="noresaltado"><?php echo $dato; ?></span></h1>
<?php }	
	 while(is_array($res) && (list($ID,$DATO)=each($res))){
	 //con $DATO[DescripcionEnlace]; se muestra la descripcion del enlace
?>
<ul>
<li><a class="enlacegrande" href="http://<?php echo $DATO[Enlace]; ?>" target="_blank"><?php echo $DATO[Enlace]; ?></a><br />
<p style="margin-left:15px; margin-bottom:10px; margin-top:0px; font-size:12px;"><?php echo quitar_caracteres_filtros($DATO[DescripcionEnlace]);?></p></li>
</ul>
<?php 
} 
}
?>
</div>
</div>
<?php 	include "pie_pagina.php"; ?>
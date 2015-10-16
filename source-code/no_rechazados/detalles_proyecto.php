<?PHP 
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	
	$query =<<<QUERY
	SELECT *, proyectos.Enlace as EnlaceP FROM proyectos, usuarios, concursos WHERE usuarios.IdUsuario = proyectos.IdUsuario 
	AND concursos.IdConcurso = proyectos.IdConcurso AND EstadoProyecto = 'A'
	AND IdProyecto = $_GET[IdProyecto]
QUERY;
	$res_p=consultar($query);
	if(!is_array($res_p) || count($res_p) <=0){
		mensajes_advertencia("No hay informaci&oacute;n que mostrar.","principal.php");
	}
	(list($Id,$Dato)=each($res_p));
	$NombreProyecto 	= quitar_caracteres_filtros($Dato[NombreProyecto]);
	$Usuario 			= quitar_caracteres_filtros($Dato[CuentaUsuario]);
	$Enlace 			= /*"http://".*/quitar_caracteres_filtros($Dato['EnlaceP']);
	$Texto 				= stripslashes($Dato[Texto]);
	$FechaIngreso 		= quitar_caracteres_filtros($Dato[FechaIngreso]);
	$FechaIngreso		= substr($FechaIngreso,0,10);	
	
	$NombreConcurso 	= quitar_caracteres_filtros($Dato[NombreConcurso]);
	$Convocante			= quitar_caracteres_filtros($Dato[Convocante]);
	$FechaEntrega 		= $Dato[FechaEntrega];
	$EnlaceC 			= /*"http://".*/quitar_caracteres_filtros($Dato['Enlace']);
	
	$query =<<<QUERY
	SELECT * FROM adjuntosproyectos 
	WHERE IdProyecto = $_GET[IdProyecto] AND EstadoAdjunto = 'A'
QUERY;

	$res_a=consultar($query);
	
	$query =<<<QUERY
	SELECT * FROM comentarios 
	WHERE IdForaneo = $_GET[IdProyecto] AND TipoForaneo = 'P' AND EstadoComentario = 'A'
	ORDER BY IdComentario DESC
QUERY;

	$res_com = consultar($query);
	
	include "encabezado.php";
	include "menu.php";	
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<script language="javascript" type="text/javascript" src="./jscripts/funciones.js"></script>
<div id="contenido">

<div id="navegacion2"><a href="principal.php">inicio</a> > <a href="proyectos_rechazados.php">proyectos rechazados</a> > detalle proyecto rechazado</div>
<div id="parrafoprincipal">
<h1></h1>
<div>

<div class="imgderecha2">
<a href="JavaScript: abrir_imagen('<?php echo $Dato[Imagen]; ?>','<?php echo $Dato[ComentarioImagen]; ?>')"><img src="./img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Dato[Imagen]; ?>" width="200" class="imgderecha"></a><br />
<div style="text-align:right; margin-bottom:15px; margin-left:15px;"><span class="noresaltado2"><?php echo $Dato[ComentarioImagen]; ?></span></div>

<?php if($Dato[Imagen2]!=""){ ?>

<a  href="JavaScript: abrir_imagen('<?php echo $Dato[Imagen2]; ?>','<?php echo $Dato[ComentarioImagen2]; ?>')"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Dato[Imagen2]; ?>" width="200" class="imgderecha"></a><br />
<div style="text-align:right; margin-bottom:15px; margin-left:15px;"><span class="noresaltado2"><?php echo $Dato[ComentarioImagen2]; ?></span></div>

<?php } ?>
<?php if($Dato[Imagen3]!=""){ ?>

<a href="JavaScript: abrir_imagen('<?php echo $Dato[Imagen3]; ?>','<?php echo $Dato[ComentarioImagen3]; ?>')" ><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Dato[Imagen3]; ?>" width="200" class="imgderecha"></a><br />
<div style="text-align:right; margin-bottom:15px; margin-left:15px;"><span class="noresaltado2"><?php echo $Dato[ComentarioImagen3]; ?></span></div>
<?php } ?>
</div>
<p>
<span class="titulogrande"><?php echo $NombreProyecto; ?></span>&nbsp;<span class="titulonoresaltado">por <?php echo $Usuario; ?></span><br />
</p>
<p>
<span class="noresaltado">Rechazado por la convocatoria:</span>&nbsp;<a href="detalles_concurso_activo.php?IdConcurso=<?php echo $Dato[IdConcurso]; ?>" target="_top" title="Ver detalles convocatoria"><?php echo $NombreConcurso; ?></a><br />
</p>
<p>
<span class="noresaltado">Introducido el dia:</span> <?php echo fecha_espenol($FechaIngreso); ?><br />
</p>
<p><span class="justificada"><?php echo $Texto; ?></span><br /></p>

<p>
<span class="noresaltado">Enlace proyecto</span>:&nbsp;<a href="http://<?php echo $Enlace; ?>"><?php echo $Enlace; ?></a><br />
</p>


	<?php
	$cadena_html = "";
	while (is_array($res_a) && (list($Id,$Dato)=each($res_a))){
		$cadena_html .= "<p><a href=\"$Dato[Archivo]\" target=\"_blank\">1 archivo adjunto <img src=\"iconos/paperclip.gif\" /></a><br></p>";
	}
	echo $cadena_html;
	?><br />


<img src="imagenes/comment.png" />&nbsp;<a class="comentario" href="nuevo_comentario.php?TipoForaneo=P&IdForaneo=<?php echo $_GET[IdProyecto]; ?>" target="_top">Agregar Comentario</a><br />
</div>


 <?php 
 while (is_array($res_com) && (list($Id,$Dato)=each($res_com))){ ?>
<div class="comentario">
     <div class="comment-head mini-d-head">
       <img src="imagenes/icon_user.png" />&nbsp;&nbsp;<?php echo $Dato[NombreComentario]; ?>&nbsp;<span class="noresaltado"">(<?php echo fecha_espenol2($Dato[FechaIngresoComentario]); ?>)</span>
     </div>
            <div class="clear"></div>
     <div class="comment-body mini-d">
       <p><?php echo $Dato[Comentario]; ?></p>
     </div>
     <!-- end new comment container -->
</div>
      <?php  } ?>
 

</div>
</div>
<?php
	include "pie_pagina.php";
?>
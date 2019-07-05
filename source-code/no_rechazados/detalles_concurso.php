<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/operaciones.php";
	include "./librerias/lib_mensajes.php";

	$IdConcurso=$_GET[IdConcurso];

	$query =<<<QUERY
	SELECT * FROM concursos WHERE EstadoConcurso = 'A'
	AND IdConcurso = $IdConcurso 
QUERY;
	$res=consultar($query);
	if(!is_array($res)){
		mensajes_advertencia("No hay concurso que mostrar","principal.php");
	}
	
	
	
	/* Lista de proyectos */
	$query =<<<QUERY
		SELECT * FROM proyectos WHERE EstadoProyecto = 'A'
		AND IdConcurso = $IdConcurso
QUERY;
	$res_p=consultar($query);
	$proyectos_concurso = "";

	while(is_array($res_p) && (list($Id_P,$Dato_P) = each($res_p))){			
	$proyectos_concurso .= " <li class=\"flecha\"></span> &nbsp; <a href=\"detalles_proyecto.php?IdProyecto=$Dato_P[IdProyecto]\" target=\"_top\">$Dato_P[NombreProyecto] </a> &nbsp; <a href=\"eliminar_concurso_proyecto.php?IdProyecto=$Dato_P[IdProyecto]\" target=\"_top\" title=\"eliminar proyecto\"><img src=\"iconos/delete.gif\" /></a></li>";

	}
	if($proyectos_concurso != "")			 
		$proyectos_concurso = "<span id=\"noresaltado\">Proyectos:</span><ul>".$proyectos_concurso."</ul>";
	
		
		
	list($Id,$Dato) = each($res);
	$id_diciplina = $Dato[IdDiciplina];
	$id_modalidad = $Dato[IdModalidad];
	
	$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
	$Convocante = quitar_caracteres_filtros($Dato[Convocante]);
	$Descripcion = quitar_caracteres_filtros($Dato[Descripcion]);
	$Enlace = quitar_caracteres_filtros($Dato[Enlace]);
	$FechaEntrega = $Dato[FechaEntrega];
	
	if(!isset($FechaEntrega) && $FechaEntrega == ""){
		$FechaEntrega = fecha_actual();
	}
	
	
	if($datos_no_llenos != "") $mensaje_error= $LLENAR_LOS_SIG_DATOS.$datos_no_llenos;	
	
	$arreglo_diciplinas = retornar_diciplinas();
	if(count($arreglo_diciplinas) <= 0){
		mensajes_advertencia($NO_HAY_DICIPLINAS,"principal.php");
	}
	$arreglo_modalidades = retornar_modalidades();
	if(count($arreglo_modalidades) <= 0){
		mensajes_advertencia($NO_HAY_MODALIDADES,"principal.php");
	}

	$query =<<<QUERY
	SELECT * FROM comentarios 
	WHERE IdForaneo = $IdConcurso AND TipoForaneo = 'C' AND EstadoComentario = 'A'
	ORDER BY IdComentario DESC
QUERY;

	$res_com = consultar($query);
	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<div id="navegacion2"><a href="principal.php">inicio</a> > <a href="historial_concurso.php">historial convocatorias</a> > detalle convocatoria</div>
<div class="parrafoprincipal"> 
			<h1><?php echo $NombreConcurso; ?></h1>

			<span id="noresaltado">Convocante: </span><?php echo $Convocante; ?><br />
			<span id="noresaltado">Disciplina: </span><?php echo $arreglo_diciplinas["$id_diciplina"]; ?><br />
			<span id="noresaltado">Modalidad: </span><?php echo $arreglo_modalidades[$id_modalidad]; ?><br />		
			<span id="noresaltado">Fecha entrega: </span><?php echo fecha_espenol($Dato[FechaEntrega]); ?><br />
			<span id="noresaltado">Descripción: </span><?php echo $Descripcion; ?><br />
			<span id="noresaltado">Enlace: </span><a href="http://<?php echo $Enlace; ?>" target="_blank"><?php echo $Enlace; ?></a><br />
			<?php echo $proyectos_concurso; ?><br /><br />
            <span id="noresaltado">Comentarios: </span><br />
            
            
            
            
                     <!-- comment container -->
<img src="imagenes/comment.png" />&nbsp;<a class="comentario" href="nuevo_comentario.php?TipoForaneo=C&IdForaneo=<?php echo $IdConcurso; ?>" target="_top">Agregar Comentario</a><br />


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
</div>
      <?php  } ?>
 <!-- end new comment container -->         
            
	</div>		
	</div>
<?php
	include "pie_pagina.php";
	/*    <tr>
      <td colspan="2"><div align="center">
        <input name="atras" type="button" id="atras" onclick="MM_goToURL('parent','javascript:history.back(1)');return document.MM_returnValue;" value="Atras" >
      </div></td>
    </tr>*/
?>
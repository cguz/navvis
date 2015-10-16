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
	
	$cadena = caracteres_filtros($cadena);
	$ITEMS_CONSULTAS = 10;	
	if(isset($_GET[ban]) && ($_GET[ban]=="get")){
		$cadena=base64_decode($_GET[cadena]);
		$Disciplina=$_GET[Disciplina];	
		$Modalidad=$_GET[Modalidad];	
		$primero = $_GET[primero];	
		
	}else{
		$cadena=$_POST[cadena];
		$Disciplina=$_POST[Disciplina];	
		$Modalidad=$_POST[Modalidad];	
		$primero = $_POST[primero];	
	}
	if(isset($_GET[eliminar]) && ($_GET[eliminar]=="SI")){	
		if(isset($_GET[IdConcurso])){
		$query=<<<QUERY
			UPDATE concursos SET EstadoConcurso = 'I'
			WHERE IdConcurso = $_GET[IdConcurso] 
			$campo_where
QUERY;
		}
		if(isset($_GET[IdProyecto])){
		$query=<<<QUERY
			UPDATE proyectos SET EstadoProyecto = 'I'
			WHERE IdProyecto = $_GET[IdProyecto] 
			$campo_where
QUERY;
		}
			$res=actualizar($query);
			if($res==false){
				$cadena=base64_encode($cadena);
				mensajes_advertencia("Error al actualizar Concurso.","editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Disciplina=$Disciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
			}
			$mensaje_error = "Eliminado con &eacute;xito.";
	}
	$cadena=trim($cadena);
	if($_SESSION['TipoUsuario'] != "A"){
		$campo_where .= " AND IdUsuario = $_SESSION[id_usuario_actual]";
	}
	if (strlen($cadena)> 0)
		$campo_where .=" AND NombreConcurso LIKE '%$cadena%'";
	if ($Disciplina != 0)
		$campo_where .=" AND IdDiciplina = $Disciplina";
	if ($Modalidad != 0)
		$campo_where .=" AND IdModalidad = $Modalidad";
	
	if (strlen($primero) == 0){$primero=0;}
	$ultimo = $ITEMS_CONSULTAS + 1;
	
	$arreglo_disciplinas = retornar_diciplinas();
	if(count($arreglo_disciplinas) <= 0){
		mensajes_advertencia($NO_HAY_DICIPLINAS,"principal.php");
	}
	$arreglo_modalidades = retornar_modalidades();
	if(count($arreglo_modalidades) <= 0){
		mensajes_advertencia($NO_HAY_MODALIDADES,"principal.php");
	}
	$fecha_actual = fecha_actual();
	$query =<<<QUERY
	SELECT * FROM concursos WHERE EstadoConcurso = 'A' $campo_where
	ORDER BY FechaEntrega ASC	
	LIMIT $primero,$ultimo
QUERY;
	$res=consultar($query);
	$cadena = quitar_caracteres_filtros($cadena);
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > actualizar convocatoria</div>
	<form name="consultaconcursosactivos" method="post" action="editar_eliminar_concurso.php">
    
    
    <!--Codigo para el buscador -->
	<div id="buscador">
    <div class="boton_nuevo"><a href="editar_eliminar_concurso_nuevo.php?retorno=editar_eliminar_concurso" target="_top">Nueva Convocatoria</a></div>
	  <div id="titulo_cuadro"><span id="noresaltado">Buscar convocatorias</span></div> 
		<table width="0%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
			<td><span id="noresaltado">Nombre</span></td>
			<td><input name="cadena" type="text" class="textbuscador" value="<?php echo $cadena; ?>" size="20" ></td>
		  </tr>
			<tr>
			<td><span id="noresaltado">Disciplina</span></td>
			<td>      <select name="Disciplina" class="textbuscador2">
				<option value="0">Todas las Disciplinas</option>
				  <?php
				while(is_array($arreglo_disciplinas) && (list($Id,$Dato)=each($arreglo_disciplinas))){	
					$seleccion = "";
					if($Id == $Disciplina){
						$seleccion = "selected";
					}
					echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
				}
		?>
			  </select></td>
		  </tr>
			<tr>
			<td><span id="noresaltado">Modalidad&nbsp;</span></td>
			<td>
			<select name="Modalidad" class="textbuscador2">
			  <option value="0">Todas las Modalidades&nbsp;&nbsp;&nbsp;</option>
				  <?php
				while(is_array($arreglo_modalidades) && (list($Id,$Dato)=each($arreglo_modalidades))){	
					$seleccion = "";
					if($Id == $Modalidad){
						$seleccion = "selected";			
					}
					echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
				}
		?>
			</select></td>
		  </tr>
			<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Buscar"></td>
		  </tr>
		</table>
	</div>
<!--Codigo para el buscador -->
         
  
<div class="parrafoprincipal">
<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>";
}
?>
<?php
	$cont = 0;
	$total_items = count($res);
	if($total_items == 0){
		echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$BUSQUEDA_CERO_CONCURSO."</span></div>";
	}
	while(is_array($res) && (list($Id,$Dato) = each($res)) && ($cont < $ultimo - 1)){
		$cont ++;
		$id_disciplina = $Dato[IdDiciplina];
		$id_modalidad = $Dato[IdModalidad];
		
		$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
		$Convocante = quitar_caracteres_filtros($Dato[Convocante]);
		$Descripcion = substr(quitar_caracteres_filtros($Dato[Descripcion]),0,150)."...";
		$Enlace = /*"http://".*/quitar_caracteres_filtros($Dato[Enlace]);
		$cadena2=base64_encode($cadena);
		
		
		$query =<<<QUERY
		SELECT * FROM proyectos WHERE EstadoProyecto = 'A'
		AND IdConcurso = $Dato[IdConcurso]
QUERY;
		$res_p=consultar($query);
		$proyectos_concurso = "";

		while(is_array($res_p) && (list($Id_P,$Dato_P) = each($res_p))){			
		$proyectos_concurso .= " <li class=\"flecha\"></span> &nbsp; <a href=\"detalles_proyecto.php?IdProyecto=$Dato_P[IdProyecto]\" target=\"_top\">$Dato_P[NombreProyecto] </a> &nbsp; <a href=\"eliminar_concurso_proyecto.php?IdProyecto=$Dato_P[IdProyecto]\" target=\"_top\" title=\"eliminar proyecto\"><img src=\"iconos/delete.gif\" /></a></li>";

		}
		if($proyectos_concurso != "")			 
		$proyectos_concurso = "<span id=\"noresaltado\">Proyectos:</span><ul>".$proyectos_concurso."</ul>";
		$query =<<<QUERY
		SELECT * FROM comentarios 
		WHERE IdForaneo = '$Dato[IdConcurso]' AND TipoForaneo = 'C' AND EstadoComentario = 'A'
		ORDER BY IdComentario DESC
QUERY;

		$res_com = consultar($query);
		
		
		
?>

<h1><a href="detalles_concurso.php?IdConcurso=<?php echo $Dato[IdConcurso]; ?>" target="_top"><?php echo $NombreConcurso; ?></a>&nbsp;
<a href="editar_concurso.php?cadena=<?php echo $cadena2; ?>&Modalidad=<?php echo $Modalidad; ?>&Disciplina=<?php echo $Disciplina; ?>&primero=<?php echo $primero; ?>&IdConcurso=<?php echo $Dato[IdConcurso]; ?>&ban=get" target="_top" title="editar"><img src="iconos/edit.gif" /></a>&nbsp;<a href="eliminar_concurso.php?cadena=<?php echo $cadena; ?>&Modalidad=<?php echo $Modalidad; ?>&Disciplina=<?php echo $Disciplina; ?>&primero=<?php echo $primero; ?>&IdConcurso=<?php echo $Dato[IdConcurso]; ?>&ban=get" target="_top" title="eliminar"><img src="iconos/delete.gif" /></a>
</h1>

<div class="parrafoprincipal4">
<span class="noresaltado">Convocante:</span> <?php echo $Convocante; ?><br />
<span class="noresaltado">Disciplina:</span> <?php echo $arreglo_disciplinas[$id_disciplina]; ?><br />
<span class="noresaltado">Modalidad:</span> <?php echo $arreglo_modalidades[$id_modalidad]; ?><br />
<span class="noresaltado">Resumen:</span> <?php echo $Descripcion; ?><br />
<span class="noresaltado">Fecha entrega:</span> <?php echo fecha_espenol($Dato[FechaEntrega]); ?><br />

<?php if (!empty($Enlace)) { ?>
<span class="noresaltado">Enlace: </span><a href="http://<?php echo $Enlace; ?>" target="_blank"><?php echo $Enlace; ?></a><br />
<?php  } else {
?>
<span class="noresaltado">Enlace:</span> sin enlace<br />
<?php
}
?>
<!--Comentarios -->
    <?php 
        if (is_array($res_com)){ ?>
        <span class="noresaltado">Comentarios: </span><?php echo count($res_com); ?> <br />
        <?php  } 
    ?>	
<!--Comentarios -->
<?php echo $proyectos_concurso; ?>


</div>
<?php }		?>

<div class="listaproyectos">
        <table width="100%" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
		$cadena=base64_encode($cadena);		
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_concurso.php?cadena=$cadena&primero=$anterior&ban=get\" title=\"anterior\"><img src=\"iconos/left.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">
			  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a href=\"editar_eliminar_concurso.php?cadena=$cadena&primero=$siguiente&ban=get\" title=\"siguiente\"><img src=\"iconos/right.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>			  
</div></td>
            </tr>
      </table>
    </div>

</div>



</form>
</div>
<?php
	include "pie_pagina.php";
?>
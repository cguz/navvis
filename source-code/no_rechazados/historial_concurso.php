<?php
	include "./librerias/lib_session.inc";
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
	$cadena=trim($cadena);
	$campo_where = "";
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
	SELECT * FROM concursos WHERE FechaEntrega < '$fecha_actual'
	AND EstadoConcurso = 'A' $campo_where
	ORDER BY FechaEntrega DESC	
	LIMIT $primero,$ultimo
QUERY;
	$res=consultar($query);
	$cadena = quitar_caracteres_filtros($cadena);
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > historial convocatorias</div>
<form name="consultaconcursosactivos" method="post" action="historial_concurso.php">
<div id="buscador">
<div id="titulo_cuadro"><span id="noresaltado">Buscar convocatorias pasadas</span></div>
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
<div class="parrafoprincipal">    
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
		$query =<<<QUERY
		SELECT * FROM proyectos WHERE EstadoProyecto = 'A'
		AND IdConcurso = $Dato[IdConcurso]
QUERY;
		$res_p=consultar($query);
		$proyectos_concurso = "";

		while(is_array($res_p) && (list($Id_P,$Dato_P) = each($res_p))){			
		$proyectos_concurso .= " <li class=\"flecha\"></span> &nbsp; <a href=\"detalles_proyecto.php?IdProyecto=$Dato_P[IdProyecto]\" target=\"_top\">$Dato_P[NombreProyecto] </a></li>";

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

			<h1><a href="detalles_concurso.php?IdConcurso=<?php echo $Dato[IdConcurso]; ?>" target="_top" title="ver detalles convocatoria"><?php echo $NombreConcurso; ?></a></h1>
            
 <div class="parrafoprincipal4">
     
			<span class="noresaltado">Convocante: </span><?php echo $Convocante; ?><br />
			<span class="noresaltado">Disciplina: </span><?php echo $arreglo_disciplinas[$id_disciplina]; ?><br />
			<span class="noresaltado">Modalidad: </span><?php echo $arreglo_modalidades[$id_modalidad]; ?><br />		
			<span class="noresaltado">Resumen: </span><?php echo $Descripcion; ?><br />		
			<span class="noresaltado">Fecha entrega: </span><?php echo fecha_espenol($Dato[FechaEntrega]); ?><br />
            <?php if (!empty($Enlace)) { ?>
            <span class="noresaltado">Enlace: </span><a href="http://<?php echo $Enlace; ?>" target="_blank"><?php echo $Enlace; ?></a><br />
			<?php  } 
            ?>	
            <!--Comentarios -->
				<?php 
					if (is_array($res_com)){ ?>
					<span id="noresaltado">Comentarios: </span><?php echo count($res_com); ?> <br />
					<?php  } 
				?>	
			<!--Comentarios -->
            <?php echo $proyectos_concurso; ?>
</div>

<?php
	}	
?>

<div class="listaproyectos">
        <table width="100%" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
		$cadena=base64_encode($cadena);		
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"historial_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Disciplina=$Disciplina&primero=$anterior&ban=get\" title=\"anterior\"><img src=\"iconos/left.gif\" /></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a href=\"historial_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Disciplina=$Disciplina&primero=$siguiente&ban=get\" title=\"siguiente\"><img src=\"iconos/right.gif\" /></a>";
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
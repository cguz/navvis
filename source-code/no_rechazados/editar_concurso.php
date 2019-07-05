<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/operaciones.php";
	include "./librerias/lib_mensajes.php";
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	$campo_where = "";
	if($_SESSION['TipoUsuario'] != 'A'){
		$campo_where .= " AND IdUsuario = $_SESSION[id_usuario_actual]";
	}
	
	$cadena=$_GET[cadena];
	$Modalidad=$_GET[Modalidad];
	$Diciplina=$_GET[Diciplina];
	$primero=$_GET[primero];
	$IdConcurso=$_GET[IdConcurso];
	
	
	$mensaje_error = "";
	$datos_no_llenos = "";
	if(isset($_GET[accion]) && $_GET[accion] == "editar"){	
		if(isset($_POST[NombreConcurso]) && $_POST[NombreConcurso] != ""){
			if(isset($_POST[Convocante]) && $_POST[Convocante] != ""){
				if(isset($_POST[Descripcion]) && $_POST[Descripcion] != ""){
					//if(isset($_POST[Descripcion]) && $_POST[Enlace] != ""){
						$bandera_enlace = true;
						if(isset($_POST[Enlace]) && $_POST[Enlace] != ""){ 
							if(ValidarUrl($_POST[Enlace])){
								$bandera_enlace = true;
							}else $bandera_enlace = false;
						}
						if($bandera_enlace){
						$_POST[NombreConcurso]	= caracteres_filtros($_POST[NombreConcurso]);
						$_POST[Convocante]   	= caracteres_filtros($_POST[Convocante]);   
						$_POST[Descripcion]		= caracteres_filtros($_POST[Descripcion]);
						$_POST[Enlace]			= caracteres_filtros($_POST[Enlace]);
						$fecha_hora_actual		= fecha_hora_actual();
						$query =<<<QUERY
						UPDATE concursos SET NombreConcurso = '$_POST[NombreConcurso]', Convocante = '$_POST[Convocante]', 
						IdDiciplina = '$_POST[Diciplina]', IdModalidad = '$_POST[Modalidad]', FechaEntrega = '$_POST[FechaEntrega]',
						Descripcion = '$_POST[Descripcion]', Enlace = '$_POST[Enlace]'
						WHERE IdConcurso = $IdConcurso AND EstadoConcurso = 'A' $campo_where
QUERY;
						$res=actualizar($query);
						if($res==false){
							$mensaje_error = $ERROR_INSERTAR_CONCURSO;
						}else{			
							mensajes_exito("Concurso editado con &eacute;xito.","editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Diciplina=$Diciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
						}
						}else $datos_no_llenos .= "Direccion web no valida, por favor verifique el campo enlace.";
					//}else $datos_no_llenos .= "Enlace.";
				}else $datos_no_llenos .= "Descripci&oacute;n. \n";
			}else $datos_no_llenos .= "Convocante. \n";
		}else $datos_no_llenos .= "Nombre Concurso. \n";
		$NombreConcurso	= quitar_caracteres_filtros($_POST[NombreConcurso]);
		$Convocante   	= quitar_caracteres_filtros($_POST[Convocante]);   
		$id_diciplina		= quitar_caracteres_filtros($_POST[Diciplina]);
		$id_modalidad		= quitar_caracteres_filtros($_POST[Modalidad]);
		$FechaEntrega	= quitar_caracteres_filtros($_POST[FechaEntrega]);
		$Descripcion	= quitar_caracteres_filtros($_POST[Descripcion]);
		$Enlace			= quitar_caracteres_filtros($_POST[Enlace]);
	}else{
		$query =<<<QUERY
		SELECT * FROM concursos WHERE EstadoConcurso = 'A'
		AND IdConcurso = $IdConcurso 
		$campo_where
QUERY;
		$res=consultar($query);
		if(!is_array($res)){
			mensajes_advertencia("No hay concurso que eliminar","editar_eliminar_concurso.php?cadena=$cadena&Modalidad=$Modalidad&Diciplina=$Diciplina&primero=$primero&IdConcurso=$IdConcurso&ban=get");
		}
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

	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<script src="./jscripts/calendario.js" type="text/javascript" language="javascript">
</script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="editar_eliminar_concurso.php">actualizar convocatoria</a> &gt; editar convocatoria </div>

<div class="parrafoprincipal">

<h1>Editar convocatoria/concurso</h1>	

<div class="introducirconcurso">

<form name="formulario" method="post" action="editar_concurso.php?accion=editar&cadena=<?php echo $cadena; ?>&Modalidad=<?php echo $Modalidad; ?>&Diciplina=<?php echo $Diciplina; ?>&primero=<?php echo $primero; ?>&IdConcurso=<?php echo $IdConcurso; ?>&ban=get">



<div class="campotexto">
<span class="noresaltado">Nombre*</span><br />
<input name="NombreConcurso" type="text" size="30" maxlength="60" value="<?php echo $NombreConcurso; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<span class="noresaltado">Convocante*</span><br />
<input name="Convocante" type="text" size="30" maxlength="60" value="<?php echo $Convocante; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<span class="noresaltado">Disciplina*</span><br />
<select name="Diciplina" class="inputcampotexto">
<?php
		while(is_array($arreglo_diciplinas) && (list($Id,$Dato)=each($arreglo_diciplinas))){	
			$seleccion = "";
			if($Id == $id_diciplina){
				$seleccion = "selected";			
			}
			echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
		}
?>
		</select>
</div>

<div class="campotexto">
<span class="noresaltado">Modalidad*</span><br />
<select name="Modalidad" class="inputcampotexto">
<?php
		while(is_array($arreglo_modalidades) && (list($Id,$Dato)=each($arreglo_modalidades))){	
			$seleccion = "";
			if($Id == $id_modalidad){
				$seleccion = "selected";			
			}
			echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
		}
?>
          </select>
</div>
<div class="campotexto">
<span id="noresaltado">Fecha entrega*</span>
<a href="javascript:show_calendar('formulario.FechaEntrega');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;" title="desplegar calendario"><img src="./imagenes/calendario.gif" align="absmiddle" alt="Desplegar Calendario"></a><br />
<input name="FechaEntrega" type="text" size="10" maxlength="10" value="<?php echo $FechaEntrega; ?>" readonly="true" class="inputcampotexto">
          
</div>

<div class="campotexto">
<span class="noresaltado">Descripci&oacute;n*</span><br />
<textarea name="Descripcion" cols="40" rows="5" class="inputcampotexto"><?php echo $Descripcion; ?></textarea>
</div>

<div class="campotexto">
<span class="noresaltado">Enlace</span><br />
<input name="<?php echo Enlace; ?>" type="text" size="30" maxlength="255" value="<?php echo $Enlace; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
 <input type="submit" name="Submit" value="Editar Concurso">&nbsp;<span class="noresaltado2">*campos obligatorios</span>
</div>

</form>
<div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>

</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>